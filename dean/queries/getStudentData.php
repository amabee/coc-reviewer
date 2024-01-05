<?php
include('../../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['studentId'])) {
    try {
        $studentId = filter_input(INPUT_GET, 'studentId', FILTER_SANITIZE_STRING);
        $studentId = ($studentId !== false) ? $studentId : 0;
        $studentId = htmlspecialchars($studentId, ENT_QUOTES, 'UTF-8');

        $stmt = $conn->prepare("SELECT id, email, firstname, lastname,image FROM tbl_students WHERE id = ?");
        $stmt->execute([$studentId]);

        if ($stmt->rowCount() > 0) {
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($student);
        } else {
            echo json_encode(['error' => 'Student not found']);
        }
    } catch (PDOException $ex) {
        echo json_encode(['error' => 'Database error: ' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

