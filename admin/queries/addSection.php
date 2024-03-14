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
        // Audit Logging
        $auditQuery = "INSERT INTO tbl_audit (action, table_name, log_message, admin_id, timestamp, ip_addr) VALUES (:action, :table_name, :log_message, :admin_id, NOW(), :ip_addr)";
        $auditStmt = $conn->prepare($auditQuery);

        $action = "Insert";
        $table_name = "tbl_section";
        $log_message = "Admin with admin id: {$_SESSION['admin_id']} added new section with section name: $sectionName and teacher id: $teacherId";
        $adminId = $_SESSION['admin_id'];
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $auditStmt->bindParam(':action', $action, PDO::PARAM_STR);
        $auditStmt->bindParam(':table_name', $table_name, PDO::PARAM_STR);
        $auditStmt->bindParam(':log_message', $log_message, PDO::PARAM_STR);
        $auditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
        $auditStmt->bindParam(':ip_addr', $ipAddress, PDO::PARAM_STR);

        $auditSuccess = $auditStmt->execute();

        if ($auditSuccess) {
            $response = array('status' => 'success', 'message' => 'Section added successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Failed to log audit information');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to add section');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
