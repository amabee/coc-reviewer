<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['student_id'])) {

    try {

        $studentId = filter_input(INPUT_GET, 'student_id', FILTER_SANITIZE_STRING);
        $studentId = ($studentId !== false) ? $studentId : 0;
        $studentId = htmlspecialchars($studentId, ENT_QUOTES, 'UTF-8');

        $query = "SELECT * FROM tbl_students WHERE id = :studentId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':studentId', $studentId);
        $stmt->execute();

        $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($studentData);
    } catch (PDOException $ex) {
        echo json_encode(['error' => $ex->getMessage()]);
    }

} else {

    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
?>