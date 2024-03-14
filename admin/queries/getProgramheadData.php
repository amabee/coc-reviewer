<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['phid'])) {
    try {
        $phid = filter_input(INPUT_GET, 'phid', FILTER_SANITIZE_STRING);
        $phid = ($phid !== false) ? $phid : 0;
        $phid = htmlspecialchars($phid, ENT_QUOTES, 'UTF-8');

        $stmt = $conn->prepare("SELECT * FROM tbl_program_head WHERE faculty_id = ?");
        $stmt->execute([$phid]);

        if ($stmt->rowCount() > 0) {
            $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($teacher);
        } else {
            echo json_encode(['error' => 'Program Head not found']);
        }
    } catch (PDOException $ex) {
        echo json_encode(['error' => 'Database error: ' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

