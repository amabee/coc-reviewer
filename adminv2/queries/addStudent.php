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

        $studentId = isset($_POST['studentId']) ? sanitizeInput($_POST['studentId']) : null;
        $firstName = isset($_POST['firstName']) ? sanitizeInput($_POST['firstName']) : null;
        $lastName = isset($_POST['lastName']) ? sanitizeInput($_POST['lastName']) : null;
        $gender = isset($_POST['gender']) ? sanitizeInput($_POST['gender']) : null;
        $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : null;
        $image = isset($_POST['image']) ? sanitizeInput($_POST['image']) : "default.png";
        if ($studentId === null || $firstName === null || $lastName === null || $gender === null || $email === null) {
            echo json_encode(['error' => 'Invalid input data']);
            exit();
        }

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_students WHERE id = ? AND isActive = 'active'");
        $stmtCheck->execute([$studentId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Student already exists and is active.']);
        } else {
            $password = sha1('password');

            $stmtInsert = $conn->prepare("INSERT INTO tbl_students (id, firstname, lastname, gender, email, password, image, isActive) VALUES (?, ?, ?, ?, ?, ?,?, 'active')");
            $stmtInsert->execute([$studentId, $firstName, $lastName, $gender, $email, $password, $image]);

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
        echo json_encode(['error' => 'Database error: ' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>