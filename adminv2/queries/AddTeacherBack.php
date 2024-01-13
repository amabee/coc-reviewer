<?php
session_start();
include("../../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teacher_id'])) {
    $teacherId = $_POST['teacher_id'];

    try {
        $currentStatusQuery = "SELECT active FROM tbl_teachers WHERE teacher_id = :teacherId";
        $currentStatusStmt = $conn->prepare($currentStatusQuery);
        $currentStatusStmt->bindParam(':teacherId', $teacherId, PDO::PARAM_STR);
        $currentStatusStmt->execute();
        $currentStatusResult = $currentStatusStmt->fetch(PDO::FETCH_ASSOC);

        if ($currentStatusResult) {
            $newStatus = ($currentStatusResult['active'] == 'active') ? 'inactive' : 'active';

            $updateStatusQuery = "UPDATE tbl_teachers SET active = :newStatus WHERE teacher_id = :teacherId";
            $updateStatusStmt = $conn->prepare($updateStatusQuery);
            $updateStatusStmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
            $updateStatusStmt->bindParam(':teacherId', $teacherId, PDO::PARAM_STR);

            if ($updateStatusStmt->execute()) {
                $action = 'Update';
                $tableName = 'tbl_teachers';
                $adminId = $_SESSION['admin_id'];
                $timestamp = date("Y-m-d H:i:s");

                $statusChange = ($newStatus == 'active') ? 'inactive' : 'active';

                $logMessage = "Admin Changed status from '{$statusChange}' to '{$newStatus}'";

                $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, teacher_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :teacher_id, :admin_id, :log_message, :timestamp)";
                $insertAuditStmt = $conn->prepare($insertAuditQuery);
                $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':teacher_id', $teacherId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

                $insertAuditStmt->execute();

                echo json_encode(["success" => true, "message" => "Teacher status updated successfully", "newStatus" => $newStatus]);
            } else {
                echo json_encode(["success" => false, "message" => "Error updating teacher status"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Teacher not found"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>