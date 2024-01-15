<?php
session_start();
include("../../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ph_id'])) {
    $programHeadId = $_POST['ph_id'];

    try {
        $currentStatusQuery = "SELECT isActive FROM tbl_program_head WHERE ph_id = :programHeadId";
        $currentStatusStmt = $conn->prepare($currentStatusQuery);
        $currentStatusStmt->bindParam(':programHeadId', $programHeadId, PDO::PARAM_STR);
        $currentStatusStmt->execute();
        $currentStatusResult = $currentStatusStmt->fetch(PDO::FETCH_ASSOC);

        if ($currentStatusResult) {
            $newStatus = ($currentStatusResult['isActive'] == 'active') ? 'inactive' : 'active';

            $updateStatusQuery = "UPDATE tbl_program_head SET isActive = :newStatus WHERE ph_id = :programHeadId";
            $updateStatusStmt = $conn->prepare($updateStatusQuery);
            $updateStatusStmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
            $updateStatusStmt->bindParam(':programHeadId', $programHeadId, PDO::PARAM_STR);

            if ($updateStatusStmt->execute()) {
                $action = 'Update';
                $tableName = 'tbl_program_head';
                $adminId = $_SESSION['admin_id'];
                $timestamp = date("Y-m-d H:i:s");

                $statusChange = ($newStatus == 'active') ? 'inactive' : 'active';

                $logMessage = "Admin Changed the Program Head with ID '{$programHeadId}' status from '{$statusChange}' to '{$newStatus}'";

                $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, ph_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :ph_id, :admin_id, :log_message, :timestamp)";
                $insertAuditStmt = $conn->prepare($insertAuditQuery);
                $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':ph_id', $programHeadId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

                $insertAuditStmt->execute();

                echo json_encode(["success" => true, "message" => "Program Head status updated successfully", "newStatus" => $newStatus]);
            } else {
                echo json_encode(["success" => false, "message" => "Error updating program head status"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Program Head not found"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request. Method: {$_SERVER['REQUEST_METHOD']}, POST data: " . print_r($_POST, true)
    ]);
    
}
?>
