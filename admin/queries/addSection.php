<?php

session_start();
include('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sectionName = sanitizeInput($_POST['sectionName']);
    $teacherId = sanitizeInput($_POST['teacherId']);

    $query = "INSERT INTO `tbl_section`(`section_id`, `teacher_id`) VALUES (:sectionName, :teacherId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sectionName', $sectionName, PDO::PARAM_STR);
    $stmt->bindParam(':teacherId', $teacherId, PDO::PARAM_STR);

    $success = $stmt->execute();

    if ($success) {
        $response = array('status' => 'success', 'message' => 'Section added successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to add section');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

?>