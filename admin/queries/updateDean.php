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
    $deanId = sanitizeInput($_POST["deanId"]);
    $firstName = sanitizeInput($_POST["firstName"]);
    $lastName = sanitizeInput($_POST["lastName"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
    $hashedpassword = sha1($password);
    $status = sanitizeInput($_POST["activeStatus"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    if (!validateStatus($status)) {
        echo json_encode(["success" => false, "message" => "Invalid status"]);
        exit();
    }

    try {
        $sql = "UPDATE tbl_dean SET
            firstname = :firstName,
            lastname = :lastName,
            email = :email,
            password = :password,
            isActive = :status
            WHERE dean_id = :deanId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedpassword);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':deanId', $deanId);

        if ($stmt->execute()) {
            $logMessage = "Admin with ID: {$_SESSION['admin_id']} updated dean data for dean with ID: $deanId. IP Address: {$_SERVER['REMOTE_ADDR']}";
            $auditStmt = $conn->prepare("INSERT INTO tbl_audit (action, table_name, log_message, admin_id, ip_addr, timestamp) VALUES ('update', 'tbl_dean', ?, ?, ?, NOW())");
            $auditStmt->execute([$logMessage, $_SESSION['admin_id'], $_SERVER['REMOTE_ADDR']]);

            echo json_encode(["success" => true, "message" => "Dean data updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating dean data"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "PDO Exception: " . $e->getMessage()]);
    }

    $conn = null;

} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
