<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['admin_id'])) {
    $admin_id = sanitizeInput($_GET['admin_id']);

    $query = "SELECT admin_id, firstname, lastname, email FROM tbl_admin WHERE admin_id = :admin_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':admin_id', $admin_id);
    $stmt->execute();
    $adminInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($adminInfo);
} else {
    echo json_encode(['error' => 'Invalid request parameters']);
}
?>
