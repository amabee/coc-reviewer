<?php
session_start();
include("../../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    $studentId = $_POST['student_id'];

    try {
        // Get current student status
        $currentStatusQuery = "SELECT isActive FROM tbl_students WHERE id = :studentId";
        $currentStatusStmt = $conn->prepare($currentStatusQuery);
        $currentStatusStmt->bindParam(':studentId', $studentId, PDO::PARAM_STR);
        $currentStatusStmt->execute();
        $currentStatusResult = $currentStatusStmt->fetch(PDO::FETCH_ASSOC);

        if ($currentStatusResult) {
            // Determine new status
            $newStatus = ($currentStatusResult['isActive'] == 'active') ? 'inactive' : 'active';

            // Update student status
            $updateStatusQuery = "UPDATE tbl_students SET isActive = :newStatus WHERE id = :studentId";
            $updateStatusStmt = $conn->prepare($updateStatusQuery);
            $updateStatusStmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
            $updateStatusStmt->bindParam(':studentId', $studentId, PDO::PARAM_STR);

            if ($updateStatusStmt->execute()) {
                // Log audit information
                $action = 'Update';
                $tableName = 'tbl_students';
                $adminId = $_SESSION['admin_id'];
                $timestamp = date("Y-m-d H:i:s");

                // Determine the actual status change for the log message
                $statusChange = ($newStatus == 'active') ? 'inactive' : 'active';

                $logMessage = "Changed status from '{$statusChange}' to '{$newStatus}'";

                $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, student_id, admin_id, log_message, timestamp) VALUES (:action, :table_name, :student_id, :admin_id, :log_message, :timestamp)";
                $insertAuditStmt = $conn->prepare($insertAuditQuery);
                $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':student_id', $studentId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
                $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

                $insertAuditStmt->execute();

                echo json_encode(["success" => true, "message" => "Student status updated successfully", "newStatus" => $newStatus]);
            } else {
                echo json_encode(["success" => false, "message" => "Error updating student status"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Student not found"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>