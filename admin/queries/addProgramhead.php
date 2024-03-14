<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require('../../includes/connection.php');

// Function to sanitize input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $facultyId = sanitizeInput($_POST['facultyId']);
        $firstName = sanitizeInput($_POST['facultyFirstName']);
        $lastName = sanitizeInput($_POST['facultyLastName']);
        $gender = sanitizeInput($_POST['gender']);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if (empty($facultyId) || empty($firstName) || empty($lastName) || empty($gender) || empty($email)) {
            echo json_encode(['error' => 'All fields are required.']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            exit;
        }

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_program_head WHERE faculty_id = ?");
        $stmtCheck->execute([$facultyId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Faculty ID already exists.']);
        } else {
            $password = sha1($_POST['password']);

            $stmtInsert = $conn->prepare("INSERT INTO tbl_program_head (faculty_id, faculty_firstname, faculty_lastname, gender, email, password, isActive) VALUES (?, ?, ?, ?, ?, ?, 'active')");
            $stmtInsert->execute([$facultyId, $firstName, $lastName, $gender, $email, $password]);

            if ($stmtInsert->rowCount() > 0) {
                // Audit Logging
                $adminId = $_SESSION['admin_id'];
                $timestamp = date("Y-m-d H:i:s");
                $ipAddress = $_SERVER['REMOTE_ADDR'];
                $auditLogQuery = "INSERT INTO tbl_audit (action, table_name, log_message, admin_id, timestamp, ip_addr) VALUES (?, ?, ?, ?, ?, ?)";
                $auditLogStmt = $conn->prepare($auditLogQuery);
                $action = "INSERT";
                $tableName = "tbl_program_head";
                $logMessage = "Admin with admin id: {$_SESSION['admin_id']} created new program head with faculty ID: $facultyId";
                $auditLogStmt->execute([$action, $tableName, $logMessage, $adminId, $timestamp, $ipAddress]);

                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['error' => 'Failed to insert data.']);
            }
        }
    } catch (PDOException $ex) {
        error_log('Database error: ' . $ex->getMessage());
        echo json_encode(['error' => 'An unexpected error occurred.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
