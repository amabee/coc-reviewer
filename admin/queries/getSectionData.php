<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['sectionId'])) {
    try {
        $sectionId = filter_input(INPUT_GET, 'sectionId', FILTER_SANITIZE_STRING);
        $sectionId = ($sectionId !== false) ? $sectionId : 0;
        $sectionId = htmlspecialchars($sectionId, ENT_QUOTES, 'UTF-8');

        $stmt = $conn->prepare("SELECT * FROM tbl_section WHERE section_id = ?");
        $stmt->execute([$sectionId]);

        if ($stmt->rowCount() > 0) {
            $section = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($section);
        } else {
            echo json_encode(['error' => 'section not found']);
        }
    } catch (PDOException $ex) {
        echo json_encode(['error' => 'Database error: ' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

