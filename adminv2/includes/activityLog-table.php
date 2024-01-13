<?php
session_start();
include("../../includes/connection.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$resultsPerPage = 10;

$offset = ($page - 1) * $resultsPerPage;

$query = "SELECT * FROM tbl_audit ORDER BY timestamp ASC LIMIT :offset, :limit";
$stmt = $conn->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($students as $student) {
    $rowsHtml .= '<tr>
            <td>' . $student['id'] . '</td>
            <td>' . $student['action'] . '</td>
            <td>' . $student['table_name'] . '</td>
            <td style="word-wrap: break-word; max-width: 150px;">' . $student['log_message'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $student['student_id'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $student['teacher_id'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $student['admin_id'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $student['dean_id'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $student['ph_id'] . '</td>
            <td>' . $student['timestamp'] . '</td>
          </tr>
          ';
}

$totalPagesQuery = "SELECT CEIL(COUNT(*) / :limit) AS totalPages FROM tbl_audit";
$totalPagesStmt = $conn->prepare($totalPagesQuery);
$totalPagesStmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$totalPagesStmt->execute();
$totalPagesResult = $totalPagesStmt->fetch(PDO::FETCH_ASSOC);
$totalPages = $totalPagesResult['totalPages'];

$jsonResponse = [
    'totalPages' => $totalPages,
    'activityLogHtml' => $rowsHtml
];

header('Content-Type: application/json');
echo json_encode($jsonResponse);
