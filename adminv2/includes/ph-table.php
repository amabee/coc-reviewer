<?php
session_start();
include("../../includes/connection.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$resultsPerPage = 10;

$offset = ($page - 1) * $resultsPerPage;

$query = "SELECT ph_id, firstname, lastname, gender, email, isActive FROM tbl_program_head ORDER BY isActive ASC LIMIT :offset, :limit";
$stmt = $conn->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$programHeads = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($programHeads as $programHead) {
    $rowsHtml .= '<tr>
            <td style="word-wrap: break-word; max-width: 100px;">' . $programHead['ph_id'] . '</td>
            <td>' . $programHead['firstname'] . '</td>
            <td>' . $programHead['lastname'] . '</td>
            <td>' . $programHead['gender'] . '</td>
            <td>' . $programHead['email'] . '</td>
            <td>';

    if ($programHead['isActive'] == 'active') {
        $rowsHtml .= "<span class='status active'>" . $programHead["isActive"] . "</span>";
        $buttonClass = "btn-danger";
        $buttonText = "Remove";
    } else if ($programHead['isActive'] == 'inactive') {
        $rowsHtml .= "<span class='status inactive'>" . $programHead["isActive"] . "</span>";
        $buttonClass = "btn-success";
        $buttonText = "Add Back";
    }

    $rowsHtml .= '</td>

    <td>
        <button type="button" class="updateProgramHeadBtn btn-primary">Update</button>
        <button type="button" class="toggleProgramHeadStatusBtn ' . $buttonClass . '" data-ph-id="' . $programHead['ph_id'] . '">' . $buttonText . '</button>
    </td>
          </tr>
          ';
}

$totalPagesQuery = "SELECT CEIL(COUNT(*) / :limit) AS totalPages FROM tbl_program_head";
$totalPagesStmt = $conn->prepare($totalPagesQuery);
$totalPagesStmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$totalPagesStmt->execute();
$totalPagesResult = $totalPagesStmt->fetch(PDO::FETCH_ASSOC);
$totalPages = $totalPagesResult['totalPages'];

$jsonResponse = [
    'totalPages' => $totalPages,
    'phsHtml' => $rowsHtml
];

header('Content-Type: application/json');
echo json_encode($jsonResponse);
?>
