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
    $studentId = sanitizeInput($_POST["updateStudentId"]);
    $firstName = sanitizeInput($_POST["updateFirstName"]);
    $lastName = sanitizeInput($_POST["updateLastName"]);
    $gender = sanitizeInput($_POST["updateGender"]);
    $email = sanitizeInput($_POST["updateEmail"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    try {
        $stmtSelect = $conn->prepare("SELECT * FROM tbl_students WHERE id = :studentId");
        $stmtSelect->bindParam(':studentId', $studentId);
        $stmtSelect->execute();
        $previousStudentData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        $changes = [];
        if ($previousStudentData['firstname'] !== $firstName) {
            $changes['firstname'] = ['from' => $previousStudentData['firstname'], 'to' => $firstName];
        }
        if ($previousStudentData['lastname'] !== $lastName) {
            $changes['lastname'] = ['from' => $previousStudentData['lastname'], 'to' => $lastName];
        }
        if ($previousStudentData['gender'] !== $gender) {
            $changes['gender'] = ['from' => $previousStudentData['gender'], 'to' => $gender];
        }
        if ($previousStudentData['email'] !== $email) {
            $changes['email'] = ['from' => $previousStudentData['email'], 'to' => $email];
        }

        $sql = "UPDATE tbl_students SET
        firstname = :firstName,
        lastname = :lastName,
        gender = :gender,
        email = :email
        WHERE id = :studentId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':studentId', $studentId);

        if ($stmt->execute()) {
            $action = 'Update';
            $tableName = 'tbl_students';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Updated student with ID '{$studentId}'. Changes: " . formatChanges($changes);

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, student_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :student_id, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':student_id', $studentId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            echo json_encode(["success" => true, "message" => "Student data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating student data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
