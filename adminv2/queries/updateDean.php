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
    $deanId = sanitizeInput($_POST["updateDeanId"]);
    $firstName = sanitizeInput($_POST["updateDeanFirstName"]);
    $lastName = sanitizeInput($_POST["updateDeanLastName"]);
    $gender = sanitizeInput($_POST["updateDeanGender"]);
    $email = sanitizeInput($_POST["updateDeanEmail"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    try {
        $stmtSelect = $conn->prepare("SELECT * FROM tbl_dean WHERE dean_id = :deanId");
        $stmtSelect->bindParam(':deanId', $deanId);
        $stmtSelect->execute();
        $previousDeanData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        $changes = [];
        if ($previousDeanData['firstname'] !== $firstName) {
            $changes['firstname'] = ['from' => $previousDeanData['firstname'], 'to' => $firstName];
        }
        if ($previousDeanData['lastname'] !== $lastName) {
            $changes['lastname'] = ['from' => $previousDeanData['lastname'], 'to' => $lastName];
        }
        if ($previousDeanData['gender'] !== $gender) {
            $changes['gender'] = ['from' => $previousDeanData['gender'], 'to' => $gender];
        }
        if ($previousDeanData['email'] !== $email) {
            $changes['email'] = ['from' => $previousDeanData['email'], 'to' => $email];
        }

        $sql = "UPDATE tbl_dean SET
        firstname = :firstName,
        lastname = :lastName,
        gender = :gender,
        email = :email
        WHERE dean_id = :deanId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':deanId', $deanId);

        if ($stmt->execute()) {
            $action = 'Update';
            $tableName = 'tbl_dean';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Updated dean with ID '{$deanId}'. Changes: " . formatChanges($changes);

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, dean_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :dean_id, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':dean_id', $deanId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            echo json_encode(["success" => true, "message" => "Dean data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating dean data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
