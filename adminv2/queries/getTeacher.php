<?php

include("../../includes/connection.php");

$query = "SELECT teacher_id, firstname, lastname FROM tbl_teachers";
$stmt = $conn->prepare($query);
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($teachers);
?>
