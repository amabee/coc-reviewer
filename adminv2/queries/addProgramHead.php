<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $programHeadId = $_POST['programHeadId'];
        $firstName = $_POST['programHeadFirstName'];
        $lastName = $_POST['programHeadLastName'];
        $gender = $_POST['programHeadGender'];
        $email = $_POST['programHeadEmail'];

        if (empty($programHeadId) || empty($firstName) || empty($lastName) || empty($gender) || empty($email)) {
            echo json_encode(['error' => 'All fields are required.']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            exit;
        }

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_program_head WHERE ph_id = ?");
        $stmtCheck->execute([$programHeadId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Program Head already exists.']);
        } else {
            $password = password_hash('password', PASSWORD_DEFAULT);
            
            $isActive = 'active';

            $stmtInsert = $conn->prepare("INSERT INTO tbl_program_head (ph_id, firstname, lastname, gender, email, password, isActive) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtInsert->execute([$programHeadId, $firstName, $lastName, $gender, $email, $password, $isActive]);

            $action = 'Insert';
            $tableName = 'tbl_program_head';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Added new program head with ID '{$programHeadId}'";

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, ph_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :ph_id, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':ph_id', $programHeadId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            $response = [
                'programHeadId' => $programHeadId,
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
