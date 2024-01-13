<?php
session_start();
include("../../includes/connection.php");

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

$sectionName = isset($_POST['sectionName']) ? sanitizeInput($_POST['sectionName']) : null;
$assignedTeacherId = isset($_POST['assignedTeacher']) ? sanitizeInput($_POST['assignedTeacher']) : null;

if ($sectionName === null || $assignedTeacherId === null) {
    $response = ['status' => 'error', 'message' => 'Invalid input data'];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

try {
    $query = "INSERT INTO tbl_section (section_id, teacher_id) VALUES (:sectionName, :assignedTeacherId)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sectionName', $sectionName, PDO::PARAM_STR);
    $stmt->bindParam(':assignedTeacherId', $assignedTeacherId, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Log the addition action with details
        $action = 'Add';
        $tableName = 'tbl_section';
        $adminId = $_SESSION['admin_id'];
        $timestamp = date("Y-m-d H:i:s");
        $logMessage = "Admin Added new section '{$sectionName}' with assigned teacher ID '{$assignedTeacherId}'";

        $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, admin_id, log_message, timestamp) VALUES (:action, :table_name, :admin_id, :log_message, :timestamp)";
        $insertAuditStmt = $conn->prepare($insertAuditQuery);
        $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
        $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
        $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
        $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
        $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

        $insertAuditStmt->execute();

        $response = ['status' => 'success', 'message' => 'Section added successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error adding section'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    $response = ['status' => 'error', 'message' => 'PDO Exception: ' . $e->getMessage()];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
