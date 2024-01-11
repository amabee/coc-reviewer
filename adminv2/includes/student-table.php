<?php
session_start();
include("../../includes/connection.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$resultsPerPage = 10;

$offset = ($page - 1) * $resultsPerPage;

$query = "SELECT id, firstname, lastname, gender, image, email, isActive FROM tbl_students LIMIT :offset, :limit";
$stmt = $conn->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($students as $student) {
    $rowsHtml .= '<tr>
            <td><img src="./../tmp/' . $student['image'] . '"></td>
            <td>' . $student['id'] . '</td>
            <td>' . $student['firstname'] . '</td>
            <td>' . $student['lastname'] . '</td>
            <td>' . $student['gender'] . '</td>
            <td>' . $student['email'] . '</td>
            <td>';

    if ($student['isActive'] == 'active') {
        $rowsHtml .= "<span class='status active'>" . $student["isActive"] . "</span>";
    } else if ($student['isActive'] == 'inactive') {
        $rowsHtml .= "<span class='status inactive'>" . $student["isActive"] . "</span>";
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
    'studentsHtml' => $rowsHtml
];

header('Content-Type: application/json');
echo json_encode($jsonResponse);
?>