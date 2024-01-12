<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['teacher_id'])) {

    try {
        $teacherId = filter_input(INPUT_GET, 'teacher_id', FILTER_SANITIZE_STRING);
        $teacherId = ($teacherId !== false) ? $teacherId : 0;
        $teacherId = htmlspecialchars($teacherId, ENT_QUOTES, 'UTF-8');

        $query = "SELECT * FROM tbl_teachers WHERE teacher_id = :teacherId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':teacherId', $teacherId);
        $stmt->execute();

        $teacherData = $stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($teacherData);
    } catch (PDOException $ex) {
        http_response_code(500);
        echo json_encode(['error' => $ex->getMessage()]);
    }

} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
?>