<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $teacherId = $_POST['teacherId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];

        if (empty($teacherId) || empty($firstName) || empty($lastName) || empty($gender) || empty($email)) {
            echo json_encode(['error' => 'All fields are required.']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            exit;
        }

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_teachers WHERE teacher_id = ? AND active = 'active'");
        $stmtCheck->execute([$teacherId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Teacher already exists and is active.']);
        } else {
            $password = password_hash('password', PASSWORD_DEFAULT);

            $stmtInsert = $conn->prepare("INSERT INTO tbl_teachers (teacher_id, firstname, lastname, gender, email, password, active) VALUES (?, ?, ?, ?, ?, ?, 'active')");
            $stmtInsert->execute([$teacherId, $firstName, $lastName, $gender, $email, $password]);

            if ($stmtInsert->rowCount() > 0) {
                // Insert audit log entry
                $logMessage = "Admin with admin id: {$_SESSION['admin_id']} created new teacher with ID: $teacherId";
                $auditStmt = $conn->prepare("INSERT INTO tbl_audit (action, table_name, log_message, admin_id, timestamp) VALUES ('insert', 'tbl_teachers', ?, ?, NOW())");
                $auditStmt->execute([$logMessage, $_SESSION['admin_id']]);

                $response = [
                    'teacherId' => $teacherId,
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'gender' => $gender,
                    'email' => $email
                ];

                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'Failed to add teacher']);
            }
        }
    } catch (PDOException $ex) {
        error_log('Database error: ' . $ex->getMessage());

        echo json_encode(['error' => 'An unexpected error occurred.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
