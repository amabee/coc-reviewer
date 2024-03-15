<?php
include '../includes/connection.php';

if (isset($_POST['student_id']) && isset($_POST['section_id'])) {
    $studentId = $_POST['student_id'];
    $sectionId = $_POST['section_id'];

    // Check if the student is already in the class
    $checkPresence = $conn->prepare("SELECT COUNT(*) AS count FROM tbl_studentclasses WHERE student_id = ? AND section_name = ?");
    $checkPresence->execute([$studentId, $sectionId]);
    $result = $checkPresence->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo 'Student is already in the class';
    } else {
        // Add the student to the class
        $addStudent = $conn->prepare("INSERT INTO tbl_studentclasses (section_name, student_id) VALUES (?, ?)");
        $addStudent->execute([$sectionId, $studentId]);
        echo 'Student added to the class successfully';
    }
} else {
    echo 'Invalid request';
}
?>
