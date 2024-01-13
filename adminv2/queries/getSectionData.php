<?php
session_start();
require('../../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['section_id'])) {

    try {

        $sectionId = filter_input(INPUT_GET, 'section_id', FILTER_SANITIZE_STRING);
        $sectionId = ($sectionId !== false) ? $sectionId : 0;
        $sectionId = htmlspecialchars($sectionId, ENT_QUOTES, 'UTF-8');

        $query = "
            SELECT 
                tbl_section.section_id,
                tbl_section.teacher_id,
                tbl_teachers.firstname AS teacher_firstname,
                tbl_teachers.lastname AS teacher_lastname
            FROM tbl_section
            INNER JOIN tbl_teachers ON tbl_section.teacher_id = tbl_teachers.teacher_id
            WHERE tbl_section.section_id = :sectionId";
            
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sectionId', $sectionId);
        $stmt->execute();

        $sectionData = $stmt->fetch(PDO::FETCH_ASSOC);

        $queryTeachers = "SELECT teacher_id, firstname, lastname FROM tbl_teachers";
        $stmtTeachers = $conn->prepare($queryTeachers);
        $stmtTeachers->execute();
        $teachersData = $stmtTeachers->fetchAll(PDO::FETCH_ASSOC);
      
        $sectionData['teachers'] = $teachersData;

        header('Content-Type: application/json');
        echo json_encode($sectionData);
    } catch (PDOException $ex) {
        echo json_encode(['error' => $ex->getMessage()]);
    }

} else {

    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}
?>
