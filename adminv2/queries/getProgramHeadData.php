<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['program_head_id'])) {
    try {
        $programHeadId = filter_input(INPUT_GET, 'program_head_id', FILTER_SANITIZE_STRING);
        $programHeadId = ($programHeadId !== false) ? $programHeadId : 0;
        $programHeadId = htmlspecialchars($programHeadId, ENT_QUOTES, 'UTF-8');

        $query = "SELECT * FROM tbl_program_head WHERE ph_id = :programHeadId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':programHeadId', $programHeadId);
        $stmt->execute();

        $programHeadData = $stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($programHeadData);
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
