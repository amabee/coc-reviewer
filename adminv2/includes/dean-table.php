<?php
session_start();
include("../../includes/connection.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$resultsPerPage = 10;

$offset = ($page - 1) * $resultsPerPage;

$query = "SELECT dean_id, firstname, lastname, gender, email, isActive FROM tbl_dean ORDER BY isActive ASC LIMIT :offset, :limit";
$stmt = $conn->prepare($query);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$stmt->execute();
$deans = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rowsHtml = '';

foreach ($deans as $dean) {
    $rowsHtml .= '<tr>
            <td style="word-wrap: break-word; max-width: 100px;">' . $dean['dean_id'] . '</td>
            <td>' . $dean['firstname'] . '</td>
            <td>' . $dean['lastname'] . '</td>
            <td>' . $dean['gender'] . '</td>
            <td>' . $dean['email'] . '</td>
            <td>';

    if ($dean['isActive'] == 'active') {
        $rowsHtml .= "<span class='status active'>" . $dean["isActive"] . "</span>";
        $buttonClass = "btn-danger";
        $buttonText = "Remove";
    } else if ($dean['isActive'] == 'inactive') {
        $rowsHtml .= "<span class='status inactive'>" . $dean["isActive"] . "</span>";
        $buttonClass = "btn-success";
        $buttonText = "Add Back";
    }

    $rowsHtml .= '</td>

    <td>
        <button type="button" class="updateDeanBtn btn-primary">Update</button>
        <button type="button" class="toggleDeanStatusBtn ' . $buttonClass . '" data-dean-id="' . $dean['dean_id'] . '">' . $buttonText . '</button>
    </td>
          </tr>
          ';
}


$totalPagesQuery = "SELECT CEIL(COUNT(*) / :limit) AS totalPages FROM tbl_dean";
$totalPagesStmt = $conn->prepare($totalPagesQuery);
$totalPagesStmt->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
$totalPagesStmt->execute();
$totalPagesResult = $totalPagesStmt->fetch(PDO::FETCH_ASSOC);
$totalPages = $totalPagesResult['totalPages'];

$jsonResponse = [
    'totalPages' => $totalPages,
    'deansHtml' => $rowsHtml
];

header('Content-Type: application/json');
echo json_encode($jsonResponse);
