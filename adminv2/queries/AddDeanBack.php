<?php
session_start();
include("../../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dean_id'])) {
    $deanId = $_POST['dean_id'];

    try {
        $currentStatusQuery = "SELECT isActive FROM tbl_dean WHERE dean_id = :deanId";
        $currentStatusStmt = $conn->prepare($currentStatusQuery);
        $currentStatusStmt->bindParam(':deanId', $deanId, PDO::PARAM_STR);
        $currentStatusStmt->execute();
        $currentStatusResult = $currentStatusStmt->fetch(PDO::FETCH_ASSOC);

        if ($currentStatusResult) {
            $newStatus = ($currentStatusResult['isActive'] == 'active') ? 'inactive' : 'active';

            $updateStatusQuery = "UPDATE tbl_dean SET isActive = :newStatus WHERE dean_id = :deanId";
            $updateStatusStmt = $conn->prepare($updateStatusQuery);
            $updateStatusStmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
            $updateStatusStmt->bindParam(':deanId', $deanId, PDO::PARAM_STR);

            if ($updateStatusStmt->execute()) {
                $action = 'Update';
                $tableName = 'tbl_dean';
                $adminId = $_SESSION['admin_id'];
                $timestamp = date("Y-m-d H:i:s");

                $statusChange = ($newStatus == 'active') ? 'inactive' : 'active';

                $logMessage = "Admin Changed the Dean with ID '{$deanId}' status from '{$statusChange}' to '{$newStatus}'";

                $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, dean_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :dean_id, :admin_id, :log_message, :timestamp)";
                $insertAuditStmt = $conn->prepare($insertAuditQuery);
                $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':dean_id', $deanId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

                $insertAuditStmt->execute();

                echo json_encode(["success" => true, "message" => "Dean status updated successfully", "newStatus" => $newStatus]);
            } else {
                echo json_encode(["success" => false, "message" => "Error updating dean status"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Dean not found"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
