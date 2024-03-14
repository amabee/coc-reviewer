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

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateStatus($status)
{
    return in_array($status, ['active', 'inactive']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $programHeadId = sanitizeInput($_POST["updateProgramHeadId"]);
    $firstName = sanitizeInput($_POST["updateProgramHeadFirstName"]);
    $lastName = sanitizeInput($_POST["updateProgramHeadLastName"]);
    $gender = sanitizeInput($_POST["updateProgramHeadGender"]);
    $email = sanitizeInput($_POST["updateProgramHeadEmail"]);
    $password = sanitizeInput($_POST["updateProgramHeadPassword"]);
    $hashedpassword = sha1($password);
    $status = sanitizeInput($_POST["updateProgramHeadStatus"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    if (!validateStatus($status)) {
        echo json_encode(["success" => false, "message" => "Invalid status"]);
        exit();
    }

    try {
        $sql = "UPDATE tbl_program_head SET
            faculty_firstname = :firstName,
            faculty_lastname = :lastName,
            gender = :gender,
            email = :email,
            password = :password,
            isActive = :status
            WHERE faculty_id = :programHeadId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedpassword);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':programHeadId', $programHeadId);

        if ($stmt->execute()) {
            // Insert audit log entry
            $logMessage = "Admin with ID: {$_SESSION['admin_id']} updated program head data for program head with ID: $programHeadId. IP Address: {$_SERVER['REMOTE_ADDR']}";
            $auditStmt = $conn->prepare("INSERT INTO tbl_audit (action, table_name, log_message, admin_id, ip_addr, timestamp) VALUES ('update', 'tbl_program_head', ?, ?, ?, NOW())");
            $auditStmt->execute([$logMessage, $_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);

            echo json_encode(["success" => true, "message" => "Program head data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating program head data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;

} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
