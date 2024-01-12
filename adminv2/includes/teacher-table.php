<?php
session_start();
include("../../includes/connection.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$resultsPerPage = 10;

$offset = ($page - 1) * $resultsPerPage;

$query = "SELECT teacher_id, firstname, lastname, gender, image, email, active FROM tbl_teachers ORDER BY active ASC LIMIT :offset, :limit";
$stmt = $conn->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($teachers as $teacher) {
    $rowsHtml .= '<tr>
            <td><img src="./../tmp/' . $teacher['image'] . '"></td>
            <td>' . $teacher['teacher_id'] . '</td>
            <td>' . $teacher['firstname'] . '</td>
            <td>' . $teacher['lastname'] . '</td>
            <td>' . $teacher['gender'] . '</td>
            <td>' . $teacher['email'] . '</td>
            <td>';

    if ($teacher['active'] == 'active') {
        $rowsHtml .= "<span class='status active'>" . $teacher["active"] . "</span>";
        $buttonClass = "btn-danger";
        $buttonText = "Remove";
    } else if ($teacher['active'] == 'inactive') {
        $rowsHtml .= "<span class='status inactive'>" . $teacher["active"] . "</span>";
        $buttonClass = "btn-success";
        $buttonText = "Add Back";
    }

    $rowsHtml .= '</td>

    <td>
        <button type="button" class="updateTeacherBtn btn-primary">Update</button>
        <button type="button" class="toggleTeacherStatusBtn ' . $buttonClass . '" data-teacher-id="' . $teacher['teacher_id'] . '">' . $buttonText . '</button>
    </td>
          </tr>
          ';
}

$totalPagesQuery = "SELECT CEIL(COUNT(*) / :limit) AS totalPages FROM tbl_teachers";
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