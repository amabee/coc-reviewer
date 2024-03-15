<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

function sanitizeInput($input)
{
    $sanitizedInput = trim($input);
    $sanitizedInput = stripslashes($sanitizedInput);
    $sanitizedInput = htmlspecialchars($sanitizedInput);
    return $sanitizedInput;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentSection = sanitizeInput($_POST["currentSectionId"]);
    $sectionId = sanitizeInput($_POST["updateSectionName"]);
    $teacherId = sanitizeInput($_POST["updateTeacherId"]);

    try {
        $sql = "UPDATE `tbl_section` SET `section_id`= :sectionId, `teacher_id`= :teacherId WHERE section_id = :currentSectionId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->bindParam(':teacherId', $teacherId);
        $stmt->bindParam(':currentSectionId', $currentSection);

        if ($stmt->execute()) {
            // Insert audit log entry
            $logMessage = "Admin with ID: {$_SESSION['admin_id']} updated section data for section with ID: $currentSection. IP Address: {$_SERVER['REMOTE_ADDR']}";
            $auditStmt = $conn->prepare("INSERT INTO tbl_audit (action, table_name, log_message, admin_id, ip_addr, timestamp) VALUES ('update', 'tbl_section', ?, ?, ?, NOW())");
            $auditStmt->execute([$logMessage, $_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);

            echo json_encode(["success" => true, "message" => "Section data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating section data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;

} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
