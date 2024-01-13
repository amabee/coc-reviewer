<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

function sanitizeInput($input)
{
    $sanitizedInput = trim($input);
    $sanitizedInput = stripslashes($sanitizedInput);
    $sanitizedInput = htmlspecialchars($sanitizedInput);
    return $sanitizedInput;
}

function formatChanges($changes)
{
    $formattedChanges = [];

    foreach ($changes as $field => $change) {
        $formattedChanges[] = ucfirst($field) . ": from '{$change['from']}' to '{$change['to']}'";
    }

    return implode(', ', $formattedChanges);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sectionId = sanitizeInput($_POST["updateSectionName"]);
    $assignedTeacherId = sanitizeInput($_POST["updateAssignedTeacher"]);

    try {
        $stmtSelect = $conn->prepare("SELECT * FROM tbl_section WHERE section_id = :sectionId");
        $stmtSelect->bindParam(':sectionId', $sectionId);
        $stmtSelect->execute();
        $previousSectionData = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        $changes = [];

        if ($previousSectionData['teacher_id'] !== $assignedTeacherId) {
            $changes['teacher_id'] = ['from' => $previousSectionData['teacher_id'], 'to' => $assignedTeacherId];
        }

        $sql = "UPDATE tbl_section SET teacher_id = :assignedTeacherId WHERE section_id = :sectionId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':assignedTeacherId', $assignedTeacherId);
        $stmt->bindParam(':sectionId', $sectionId);

        if ($stmt->execute()) {

            $action = 'Update';
            $tableName = 'tbl_section';
            $adminId = $_SESSION['admin_id'];
            $timestamp = date("Y-m-d H:i:s");
            $logMessage = "Admin Updated class with ID '{$sectionId}'. Changes: " . formatChanges($changes);

            $insertAuditQuery = "INSERT INTO tbl_audit (action, table_name, admin_id, log_message, timestamp) VALUES (:action, :table_name, :admin_id, :log_message, :timestamp)";
            $insertAuditStmt = $conn->prepare($insertAuditQuery);
            $insertAuditStmt->bindParam(':action', $action, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':table_name', $tableName, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':admin_id', $adminId, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':log_message', $logMessage, PDO::PARAM_STR);
            $insertAuditStmt->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);

            $insertAuditStmt->execute();

            echo json_encode(["success" => true, "message" => "Class data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating class data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
