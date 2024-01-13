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
    $teacherId = sanitizeInput($_POST["updateTeacherId"]);
    $firstName = sanitizeInput($_POST["updateTeacherFirstName"]);
    $lastName = sanitizeInput($_POST["updateTeacherLastName"]);
    $gender = sanitizeInput($_POST["updateTeacherGender"]);
    $email = sanitizeInput($_POST["updateTeacherEmail"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    try {
        // Fetch the existing teacher data before the update
        $stmtSelect = $conn->prepare("SELECT * FROM tbl_teachers WHERE teacher_id = :teacherId");
        $stmtSelect->bindParam(':teacherId', $teacherId);
        $stmtSelect->execute();
        $previousTeacherData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Compare previous and updated values for each field
        $changes = [];
        if ($previousTeacherData['firstname'] !== $firstName) {
            $changes['firstname'] = ['from' => $previousTeacherData['firstname'], 'to' => $firstName];
        }
        if ($previousTeacherData['lastname'] !== $lastName) {
            $changes['lastname'] = ['from' => $previousTeacherData['lastname'], 'to' => $lastName];
        }
        if ($previousTeacherData['gender'] !== $gender) {
            $changes['gender'] = ['from' => $previousTeacherData['gender'], 'to' => $gender];
        }
        if ($previousTeacherData['email'] !== $email) {
            $changes['email'] = ['from' => $previousTeacherData['email'], 'to' => $email];
        }

        $sql = "UPDATE tbl_teachers SET
        firstname = :firstName,
        lastname = :lastName,
        gender = :gender,
        email = :email
        WHERE teacher_id = :teacherId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':teacherId', $teacherId);

        if ($stmt->execute()) {
            // Log the update action with details on changes
            $action = 'Update';
            $tableName = 'tbl_teachers';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Updated teacher with ID '{$teacherId}'. Changes: " . formatChanges($changes);

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, teacher_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :teacher_id, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':teacher_id', $teacherId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            echo json_encode(["success" => true, "message" => "Teacher data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating teacher data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
