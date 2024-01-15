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
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($logs as $logs) {
    $rowsHtml .= '<tr>
            <td>' . $logs['id'] . '</td>
            <td>' . $logs['action'] . '</td>
            <td style="word-wrap: break-word; max-width: 80px;">' . $logs['table_name'] . '</td>
            <td style="word-wrap: break-word; max-width: 150px;">' . $logs['log_message'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $logs['admin_id'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $logs['dean_id'] . '</td>
            <td style="word-wrap: break-word; max-width: 100px;">' . $logs['ph_id'] . '</td>
            <td>' . $logs['timestamp'] . '</td>
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
