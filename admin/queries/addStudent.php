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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $studentId = sanitizeInput($_POST['studentId']);
        $firstName = sanitizeInput($_POST['firstName']);
        $lastName = sanitizeInput($_POST['lastName']);
        $gender = sanitizeInput($_POST['gender']);
        $email = sanitizeInput($_POST['email']);

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_students WHERE id = ? AND isActive = 'active'");
        $stmtCheck->execute([$studentId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Student already exists and is active.']);
        } else {
            $password = sha1('password');

            $stmtInsert = $conn->prepare("INSERT INTO tbl_students (id, firstname, lastname, gender, email, password, isActive) VALUES (?, ?, ?, ?, ?, ?, 'active')");
            $stmtInsert->execute([$studentId, $firstName, $lastName, $gender, $email, $password]);

            $response = [
                'studentId' => $studentId,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'gender' => $gender,
                'email' => $email
            ];

            echo json_encode($response);
        }
    } catch (PDOException $ex) {
        echo json_encode(['error' => 'Database error: ' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>