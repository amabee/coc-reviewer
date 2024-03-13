<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $deanId = sanitizeInput($_POST['deanId']);
        $firstName = sanitizeInput($_POST['deanFirstName']);
        $lastName = sanitizeInput($_POST['deanLastName']);
        $gender = sanitizeInput($_POST['deanGender']);
        $email = sanitizeInput($_POST['deanEmail']);

        if (empty($deanId) || empty($firstName) || empty($lastName) || empty($gender) || empty($email)) {
            echo json_encode(['error' => 'All fields are required.']);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email format.']);
            exit;
        }

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_dean WHERE dean_id = ? AND isActive = 'active'");
        $stmtCheck->execute([$deanId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Dean already exists and is active.']);
        } else {
            $password = sha1('password');

            $stmtInsert = $conn->prepare("INSERT INTO tbl_dean (dean_id, firstname, lastname, gender, email, password, isActive) VALUES (?, ?, ?, ?, ?, ?, 'active')");
            $stmtInsert->execute([$deanId, $firstName, $lastName, $gender, $email, $password]);

            if ($stmtInsert->rowCount() > 0) {
                // Audit Log
                $logMessage = "Admin with admin id: ".$_SESSION['admin_id']." Created new dean with dean ID: $deanId";
                $auditQuery = "INSERT INTO tbl_audit (action, table_name, log_message, admin_id, timestamp) VALUES ('Insert', 'tbl_deans', ?, ?, NOW())";
                $auditStmt = $conn->prepare($auditQuery);
                $auditStmt->execute([$logMessage, $_SESSION['admin_id']]);
                
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['error' => 'Failed to insert data.']);
            }
        }
    } catch (PDOException $ex) {
        error_log('Database error: ' . $ex->getMessage());
        echo json_encode(['error' => $ex->getMessage() ]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
