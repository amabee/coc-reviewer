<?php
include '../includes/connection.php';

if (isset($_POST['student_id']) && isset($_POST['section_id'])) {
    $studentId = $_POST['student_id'];
    $sectionId = $_POST['section_id'];

    $checkPresence = $conn->prepare("SELECT COUNT(*) AS count FROM tbl_studentclasses WHERE student_id = ? AND section_name = ?");
    $checkPresence->execute([$studentId, $sectionId]);
    $result = $checkPresence->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        echo json_encode(['status' => 'true']);
    } else {
        echo json_encode(['status' => 'false']);
    }
} else {
    echo json_encode(['status' => 'false']);
}
?>
