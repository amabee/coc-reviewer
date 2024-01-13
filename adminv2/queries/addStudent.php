<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function formatChanges($changes)
{
    $formattedChanges = [];

    foreach ($changes as $field => $change) {
        $formattedChanges[] = ucfirst($field) . ": from '{$change['from']}' to '{$change['to']}'";
    }

    return implode(', ', $formattedChanges);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $studentId = $_POST['studentId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $image = isset($_POST['image']) ? sanitizeInput($_POST['image']) : "default.png";

        if (empty($studentId) || empty($firstName) || empty($lastName) || empty($gender) || empty($email)) {
            echo json_encode(['error' => 'All fields are required.']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            exit;
        }

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_students WHERE id = ? AND isActive = 'active'");
        $stmtCheck->execute([$studentId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Student already exists and is active.']);
        } else {
            $password = sha1('password');

            $stmtInsert = $conn->prepare("INSERT INTO tbl_students (id, firstname, lastname, gender, email, password, image, isActive) VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
            $stmtInsert->execute([$studentId, $firstName, $lastName, $gender, $email, $password, $image]);

            $action = 'Insert';
            $tableName = 'tbl_students';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Added new student with ID '{$studentId}'";

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, student_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :student_id, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':student_id', $studentId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            $response = [
                'studentId' => $studentId,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'gender' => $gender,
                'email' => $email,
                'image' => $image
            ];

            echo json_encode($response);
        }
    } catch (PDOException $ex) {
        error_log('Database error: ' . $ex->getMessage());

        echo json_encode(['error' => 'An unexpected error occurred.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
