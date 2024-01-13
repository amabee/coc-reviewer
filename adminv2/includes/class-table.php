<?php
session_start();
include("../../includes/connection.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$resultsPerPage = 10;

$offset = ($page - 1) * $resultsPerPage;

$query = "SELECT
            tbl_section.section_id,
            tbl_section.teacher_id,
            tbl_teachers.firstname AS teacher_firstname,
            tbl_teachers.lastname AS teacher_lastname,
            COUNT(tbl_studentclasses.student_id) AS student_count
          FROM
            tbl_section
          INNER JOIN
            tbl_teachers ON tbl_section.teacher_id = tbl_teachers.teacher_id
          LEFT JOIN
            tbl_studentclasses ON tbl_section.section_id = tbl_studentclasses.section_name
          GROUP BY
            tbl_section.section_id
          ORDER BY
            tbl_section.section_id ASC
          LIMIT :offset, :limit";
$stmt = $conn->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($classes as $class) {
    $rowsHtml .= '<tr >
            <td>' . $class['section_id'] . '</td>
            <td>' . $class['teacher_firstname'] . ' ' . $class['teacher_lastname'] . '</td>
            <td>' . $class['student_count'] . '</td>
            <td>';

    $rowsHtml .= '</td>

    <td>
        <button type="button" class="updateClassBtn btn-primary">Update</button>
    </td>
          </tr>
          ';
}


$totalPagesQuery = "SELECT CEIL(COUNT(*) / :limit) AS totalPages FROM tbl_section";
$totalPagesStmt = $conn->prepare($totalPagesQuery);
$totalPagesStmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$totalPagesStmt->execute();
$totalPagesResult = $totalPagesStmt->fetch(PDO::FETCH_ASSOC);
$totalPages = $totalPagesResult['totalPages'];

$jsonResponse = [
    'totalPages' => $totalPages,
    'classesHtml' => $rowsHtml
];

header('Content-Type: application/json');
echo json_encode($jsonResponse);
