<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $deanId = $_POST['deanId'];
        $firstName = $_POST['deanFirstName'];
        $lastName = $_POST['deanLastName'];
        $gender = $_POST['deanGender'];
        $email = $_POST['deanEmail'];

        if (empty($deanId) || empty($firstName) || empty($lastName) || empty($gender) || empty($email)) {
            echo json_encode(['error' => 'All fields are required.']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            exit;
        }

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_dean WHERE dean_id = ?");
        $stmtCheck->execute([$deanId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Dean already exists.']);
        } else {
            $password = password_hash('password', PASSWORD_DEFAULT);
            
            // Set isActive column to 'active' for a new dean
            $isActive = 'active';

            $stmtInsert = $conn->prepare("INSERT INTO tbl_dean (dean_id, firstname, lastname, gender, email, password, isActive) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtInsert->execute([$deanId, $firstName, $lastName, $gender, $email, $password, $isActive]);

            $action = 'Insert';
            $tableName = 'tbl_dean';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Added new dean with ID '{$deanId}'";

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, dean_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :dean_id, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':dean_id', $deanId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            $response = [
                'deanId' => $deanId,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'gender' => $gender,
                'email' => $email,
                'isActive' => $isActive,
            ];

            echo json_encode($response);
        }
    } catch (PDOException $ex) {
        error_log('Database error: ' . $ex->getMessage());

        echo json_encode(['error' => 'An unexpected error occurred.' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
