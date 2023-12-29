<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $teacherId = $_POST['teacherId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];

        $stmtCheck = $conn->prepare("SELECT * FROM tbl_teachers WHERE teacher_id = ? AND active = 'active'");
        $stmtCheck->execute([$teacherId]);

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['error' => 'Teacher already exists and is active.']);
        } else {
            $password = sha1('password');
            $stmtInsert = $conn->prepare("INSERT INTO tbl_teachers (teacher_id, firstname, lastname, gender, email, password, active) VALUES (?, ?, ?, ?, ?, ?, 'active')");
            $stmtInsert->execute([$teacherId, $firstName, $lastName, $gender, $email, $password]);

            $response = [
                'teacherId' => $teacherId,
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
