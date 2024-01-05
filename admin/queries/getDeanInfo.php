<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
}

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['dean_id'])) {
    $dean_id = sanitizeInput($_GET['dean_id']);

    $query = "SELECT dean_id, firstname, lastname, email, isActive FROM tbl_dean WHERE dean_id = :dean_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':dean_id', $dean_id);
    $stmt->execute();
    $deanInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($deanInfo);
} else {
    http_response_code(400);
    echo 'Invalid request parameters';
}
?>