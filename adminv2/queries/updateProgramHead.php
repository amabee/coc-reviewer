<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

function sanitizeInput($input)
{
    $sanitizedInput = trim($input);
    $sanitizedInput = stripslashes($sanitizedInput);
    $sanitizedInput = htmlspecialchars($sanitizedInput);
    return $sanitizedInput;
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function formatChanges($changes)
{
    $formattedChanges = [];

    foreach ($changes as $field => $change) {
        $formattedChanges[] = ucfirst($field) . ": from '{$change['from']}' to '{$change['to']}'";
    }

    return implode(', ', $formattedChanges);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $programHeadId = sanitizeInput($_POST["updateProgramHeadId"]);
    $firstName = sanitizeInput($_POST["updateProgramHeadFirstName"]);
    $lastName = sanitizeInput($_POST["updateProgramHeadLastName"]);
    $gender = sanitizeInput($_POST["updateProgramHeadGender"]);
    $email = sanitizeInput($_POST["updateProgramHeadEmail"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    try {
        $stmtSelect = $conn->prepare("SELECT * FROM tbl_program_head WHERE ph_id = :programHeadId");
        $stmtSelect->bindParam(':programHeadId', $programHeadId);
        $stmtSelect->execute();
        $previousProgramHeadData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        $changes = [];
        if ($previousProgramHeadData['firstname'] !== $firstName) {
            $changes['firstname'] = ['from' => $previousProgramHeadData['firstname'], 'to' => $firstName];
        }
        if ($previousProgramHeadData['lastname'] !== $lastName) {
            $changes['lastname'] = ['from' => $previousProgramHeadData['lastname'], 'to' => $lastName];
        }
        if ($previousProgramHeadData['gender'] !== $gender) {
            $changes['gender'] = ['from' => $previousProgramHeadData['gender'], 'to' => $gender];
        }
        if ($previousProgramHeadData['email'] !== $email) {
            $changes['email'] = ['from' => $previousProgramHeadData['email'], 'to' => $email];
        }

        $sql = "UPDATE tbl_program_head SET
        firstname = :firstName,
        lastname = :lastName,
        gender = :gender,
        email = :email
        WHERE ph_id = :programHeadId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':programHeadId', $programHeadId);

        if ($stmt->execute()) {
            $action = 'Update';
            $tableName = 'tbl_program_head';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Updated program head with ID '{$programHeadId}'. Changes: " . formatChanges($changes);

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, ph_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :ph_id, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':ph_id', $programHeadId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            echo json_encode(["success" => true, "message" => "Program Head data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating program head data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
