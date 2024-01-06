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
            isActive = :status
            WHERE id = :studentId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':studentId', $studentId);

        if ($stmt->execute()) {
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

