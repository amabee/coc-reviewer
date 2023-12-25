<?php
session_start();
include '../includes/connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_question'])) {
    $quiz_id = filter_var($_POST['quiz_id'], FILTER_SANITIZE_STRING);
    $question_text = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
    $opt1 = filter_var($_POST['opt1'], FILTER_SANITIZE_STRING);
    $opt2 = filter_var($_POST['opt2'], FILTER_SANITIZE_STRING);
    $opt3 = filter_var($_POST['opt3'], FILTER_SANITIZE_STRING);
    $opt4 = filter_var($_POST['opt4'], FILTER_SANITIZE_STRING);
    $correct_option = filter_var($_POST['correct_option'], FILTER_SANITIZE_STRING);

    $insertStmt = $conn->prepare("INSERT INTO tbl_quizquestions (quiz_id, quiz_question, option_1, option_2, option_3, option_4, correct_answer) VALUES (:quiz_id, :quiz_question, :option_1, :option_2, :option_3, :option_4, :correct_answer)");

    $insertStmt->bindParam(':quiz_id', $quiz_id, PDO::PARAM_INT);
    $insertStmt->bindParam(':quiz_question', $question_text, PDO::PARAM_STR);
    $insertStmt->bindParam(':option_1', $opt1, PDO::PARAM_STR);
    $insertStmt->bindParam(':option_2', $opt2, PDO::PARAM_STR);
    $insertStmt->bindParam(':option_3', $opt3, PDO::PARAM_STR);
    $insertStmt->bindParam(':option_4', $opt4, PDO::PARAM_STR);
    $insertStmt->bindParam(':correct_answer', $correct_option, PDO::PARAM_STR);

    if ($insertStmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Question added successfully';
    } else {
        $response['success'] = false;
        $response['message'] = 'Failed to add question';
    }

    echo json_encode($response);
} else {

    $response['success'] = false;
    $response['message'] = 'Invalid request';


    echo json_encode($response);
}
?>