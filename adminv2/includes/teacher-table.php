<?php
session_start();
include("../../includes/connection.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$resultsPerPage = 10;

$offset = ($page - 1) * $resultsPerPage;

$query = "SELECT teacher_id, firstname, lastname, gender, image, email, active FROM tbl_teachers LIMIT :offset, :limit";
$stmt = $conn->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($students as $student) {
    $rowsHtml .= '<tr>
            <td><img src="./../tmp/' . $student['image'] . '"></td>
            <td>' . $student['teacher_id'] . '</td>
            <td>' . $student['firstname'] . '</td>
            <td>' . $student['lastname'] . '</td>
            <td>' . $student['gender'] . '</td>
            <td>' . $student['email'] . '</td>
            <td>';

    if ($student['active'] == 'active') {
        $rowsHtml .= "<span class='status active'>" . $student["active"] . "</span>";
    } else if ($student['active'] == 'inactive') {
        $rowsHtml .= "<span class='status inactive'>" . $student["active"] . "</span>";
    }

    $rowsHtml .= '</td>

    <td>
    <button type="button" class="btn-primary">Update</button>
    <button type="button" class="btn-danger">Remove</button>
</td>
          </tr>
          ';
}

$totalPagesQuery = "SELECT CEIL(COUNT(*) / :limit) AS totalPages FROM tbl_students";
$totalPagesStmt = $conn->prepare($totalPagesQuery);
$totalPagesStmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$totalPagesStmt->execute();
$totalPagesResult = $totalPagesStmt->fetch(PDO::FETCH_ASSOC);
$totalPages = $totalPagesResult['totalPages'];

$jsonResponse = [
    'totalPages' => $totalPages,
    'teachersHtml' => $rowsHtml
];

header('Content-Type: application/json');
echo json_encode($jsonResponse);
?>