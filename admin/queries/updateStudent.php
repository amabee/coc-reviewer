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
    $studentId = sanitizeInput($_POST["updateStudentId"]);
    $firstName = sanitizeInput($_POST["updateFirstName"]);
    $lastName = sanitizeInput($_POST["updateLastName"]);
    $gender = sanitizeInput($_POST["updateGender"]);
    $email = sanitizeInput($_POST["updateEmail"]);
    $password = sanitizeInput($_POST["updatePassword"]);
    $hashedpassword = sha1($password);
    $status = sanitizeInput($_POST["updateStatus"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    if (!validateStatus($status)) {
        echo json_encode(["success" => false, "message" => "Invalid status"]);
        exit();
    }

    try {
        $sql = "UPDATE tbl_students SET
            firstname = :firstName,
            lastname = :lastName,
            gender = :gender,
            email = :email,
            password = :password,
            isActive = :status
            WHERE id = :studentId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedpassword);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':studentId', $studentId);

        if ($stmt->execute()) {
            // Insert audit log entry
            $logMessage = "Admin with ID: {$_SESSION['admin_id']} updated student data for student with ID: $studentId. IP Address: {$_SERVER['REMOTE_ADDR']}";
            $auditStmt = $conn->prepare("INSERT INTO tbl_audit (action, table_name, log_message, admin_id, ip_addr, timestamp) VALUES ('update', 'tbl_students', ?, ?, ?, NOW())");
            $auditStmt->execute([$logMessage, $_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);

            echo json_encode(["success" => true, "message" => "Student data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating student data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;

} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
