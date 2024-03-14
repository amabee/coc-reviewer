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
    $teacherId = sanitizeInput($_POST["updateTeacherId"]);
    $firstName = sanitizeInput($_POST["updateTeacherFirstName"]);
    $lastName = sanitizeInput($_POST["updateTeacherLastName"]);
    $gender = sanitizeInput($_POST["updateTeacherGender"]);
    $email = sanitizeInput($_POST["updateTeacherEmail"]);
    $password = sanitizeInput($_POST["updateTeacherPassword"]);
    $hashedpassword = sha1($password);
    $status = sanitizeInput($_POST["updateTeacherStatus"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    if (!validateStatus($status)) {
        echo json_encode(["success" => false, "message" => "Invalid status"]);
        exit();
    }

    try {
        $sql = "UPDATE tbl_teachers SET
            firstname = :firstName,
            lastname = :lastName,
            gender = :gender,
            email = :email,
            password = :password,
            active = :status
            WHERE teacher_id = :teacherId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedpassword);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':teacherId', $teacherId);

        if ($stmt->execute()) {
            // Insert audit log entry
            $logMessage = "Admin with ID: {$_SESSION['admin_id']} updated teacher data for teacher with ID: $teacherId. IP Address: {$_SERVER['REMOTE_ADDR']}";
            $auditStmt = $conn->prepare("INSERT INTO tbl_audit (action, table_name, log_message, admin_id, ip_addr, timestamp) VALUES ('update', 'tbl_teachers', ?, ?, ?, NOW())");
            $auditStmt->execute([$logMessage, $_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);

            echo json_encode(["success" => true, "message" => "Teacher data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating teacher data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;

} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
