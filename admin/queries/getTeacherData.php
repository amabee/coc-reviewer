<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['teacherId'])) {
    try {
        $teacherId = filter_input(INPUT_GET, 'teacherId', FILTER_SANITIZE_STRING);
        $teacherId = ($teacherId !== false) ? $teacherId : 0;
        $teacherId = htmlspecialchars($teacherId, ENT_QUOTES, 'UTF-8');

        $stmt = $conn->prepare("SELECT teacher_id, email, firstname, lastname, image FROM tbl_teachers WHERE teacher_id = ?");
        $stmt->execute([$teacherId]);

        if ($stmt->rowCount() > 0) {
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($teacher);
        } else {
            echo json_encode(['error' => 'Teacher not found']);
        }
    } catch (PDOException $ex) {
        echo json_encode(['error' => 'Database error: ' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

