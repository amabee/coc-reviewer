<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dean_id'])) {
    try {
        $deanId = filter_input(INPUT_GET, 'dean_id', FILTER_SANITIZE_STRING);
        $deanId = ($deanId !== false) ? $deanId : 0;
        $deanId = htmlspecialchars($deanId, ENT_QUOTES, 'UTF-8');

        $query = "SELECT * FROM tbl_dean WHERE dean_id = :deanId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':deanId', $deanId);
        $stmt->execute();

        $teacherData = $stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($teacherData);
    } catch (PDOException $ex) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $ex->getMessage()]);
    }

} else {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
?>
