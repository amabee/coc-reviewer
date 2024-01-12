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

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherId = sanitizeInput($_POST["updateTeacherId"]);
    $firstName = sanitizeInput($_POST["updateTeacherFirstName"]);
    $lastName = sanitizeInput($_POST["updateTeacherLastName"]);
    $gender = sanitizeInput($_POST["updateTeacherGender"]);
    $email = sanitizeInput($_POST["updateTeacherEmail"]);

    if (!validateEmail($email)) {
        echo json_encode(["success" => false, "message" => "Invalid email address"]);
        exit();
    }

    try {
        $sql = "UPDATE tbl_teachers SET
        firstname = :firstName,
        lastname = :lastName,
        gender = :gender,
        email = :email
        WHERE teacher_id = :teacherId";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':teacherId', $teacherId);

        if ($stmt->execute()) {
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