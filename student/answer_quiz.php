<?php
session_start();
include '../includes/connection.php';

$quizId = isset($_COOKIE['quiz_id']) ? $_COOKIE['quiz_id'] : null;

if ($quizId) {
    $selExamStatement = $conn->prepare("SELECT * FROM tbl_quiz WHERE quiz_id = ?");
    $selExamStatement->execute([$quizId]);
    $selExam = $selExamStatement->fetch(PDO::FETCH_ASSOC);

    if (!$selExam) {
        echo "Error fetching exam details";
        exit();
    }
} else {
    echo "Exam ID not provided";
    exit();
}

$studentId = $_SESSION['user_id'];
$checkAttemptStatement = $conn->prepare("SELECT attempt_status FROM tbl_quizattempt WHERE quiz_id = ? AND student_id = ? ORDER BY attempt_id DESC LIMIT 1");
$checkAttemptStatement->execute([$quizId, $studentId]);
$lastAttemptStatus = $checkAttemptStatement->fetchColumn();
$selExamTimeLimit = 1;

$totalScoreStatement = $conn->prepare("SELECT numberOfItems AS total_score FROM tbl_quiz WHERE quiz_id = ?");
$totalScoreStatement->execute([$quizId]);
$totalScore = $totalScoreStatement->fetchColumn();


if ($lastAttemptStatus == 'completed') {

    $attemptScoreStatement = $conn->prepare("SELECT attempt_score FROM tbl_quizattempt WHERE quiz_id = ? AND student_id = ? ORDER BY attempt_id DESC LIMIT 1");
    $attemptScoreStatement->execute([$quizId, $studentId]);
    $lastAttemptScore = $attemptScoreStatement->fetchColumn();

    $_SESSION['total_score'] = $totalScore;
    $_SESSION['quiz_score'] = $lastAttemptScore;

    header('Location: misc/success.php');
    exit();
}

if ($selExam['quiz_type'] === 'post-test' && $lastAttemptStatus == 'failed') {
    header('Location: misc/retry_later.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quizId = isset($_POST['exam_id']) ? $_POST['exam_id'] : null;
    $studentId = $_SESSION['user_id'];
    $attemptScore = 0;
    $attempt_count = 1;

    foreach ($_POST['responses'] as $questionId => $pickedResponse) {
        $correctAnswerStatement = $conn->prepare("SELECT correct_answer FROM tbl_quizquestions WHERE question_id = ?");
        $correctAnswerStatement->execute([$questionId]);
        $correctAnswer = $correctAnswerStatement->fetchColumn();

        if ($pickedResponse == $correctAnswer) {
            $attemptScore++;
        }

        $insertResponseStatement = $conn->prepare("INSERT INTO tbl_quizresponses (quiz_id, question_id, student_id, picked_response) VALUES (?, ?, ?, ?)");
        $insertResponseStatement->execute([$quizId, $questionId, $studentId, $pickedResponse]);
    }

    $insertAttemptStatement = $conn->prepare("INSERT INTO tbl_quizattempt (quiz_id, student_id, attempt_status, attempt_score, attempt_count) VALUES (?, ?, 'completed', ?, ?)");
    $insertAttemptStatement->execute([$quizId, $studentId, $attemptScore, $attempt_count]);

    $_SESSION['quiz_score'] = $attemptScore;
    $_SESSION['total_score'] = $totalScore;

    header('Location: misc/success.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link href="../styles/quiz_style.css" rel="stylesheet">
    <style>
        .option-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 5px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .option-box.selected {
            background-color: #cce5ff;
        }
    </style>
</head>

<body>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="col-md-12">
                <div class="app-page-title">
                    <div class="page-title-wrapper">
                        <div class="page-title-heading">
                            <div>
                                <?php echo $selExam['quiz_title']; ?>
                                <div class="page-title-subheading">
                                    <?php echo $selExam['quiz_description']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="page-title-actions mr-5" style="font-size: 20px;">
                            <form name="cd">
                                <input type="hidden" name="" id="timeExamLimit"
                                    value="<?php echo $selExamTimeLimit; ?>">
                                <label>Remaining Time : </label>
                                <input style="border:none;background-color: transparent;color:blue;font-size: 25px;"
                                    name="disp" type="text" class="clock" id="txt" value="00:00" size="5"
                                    readonly="true" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 p-0 mb-4">
                <form method="post" id="quizform">
                    <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $quizId; ?>">
                    <input type="hidden" name="examAction" id="examAction">
                    <div class="question-container">
                        <?php
                        $selQuestionLimit = $conn->prepare("SELECT numberOfItems FROM tbl_quiz WHERE quiz_id = ?");
                        $selQuestionLimit->execute([$quizId]);
                        $limit = $selQuestionLimit->fetchColumn();

                        $selQuestStatement = $conn->prepare("SELECT * FROM tbl_quizquestions WHERE quiz_id = ? ORDER BY rand() LIMIT $limit");
                        $selQuestStatement->execute([$quizId]);

                        if ($selQuestStatement->rowCount() > 0) {
                            $i = 1;
                            while ($selQuestRow = $selQuestStatement->fetch(PDO::FETCH_ASSOC)) { ?>
                                <?php $questId = $selQuestRow['question_id']; ?>
                                <div class="question" data-question-id="<?php echo $questId; ?>"
                                    style="display: none; text-align: center;">
                                    <p><b>
                                            <?php echo $i++; ?> .)
                                            <?php echo $selQuestRow['quiz_question']; ?>
                                        </b></p>
                                    <div class="col-md-8 offset-md-2">
                                        <div class="option-box" data-option-id="1" onclick="selectOption(this)">
                                            <?php echo $selQuestRow['option_1']; ?>
                                        </div>

                                        <div class="option-box" data-option-id="2" onclick="selectOption(this)">
                                            <?php echo $selQuestRow['option_2']; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8 offset-md-2">
                                        <div class="option-box" data-option-id="3" onclick="selectOption(this)">
                                            <?php echo $selQuestRow['option_3']; ?>
                                        </div>

                                        <div class="option-box" data-option-id="4" onclick="selectOption(this)">
                                            <?php echo $selQuestRow['option_4']; ?>
                                        </div>
                                    </div>


                                    <input type="hidden" name="responses[<?php echo $questId; ?>]"
                                        id="response_<?php echo $questId; ?>" value="">
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <!-- <div class="question" style="text-align: center;">
                                <p><b>No questions at this moment</b></p>
                            </div> -->
                            <?php
                            header("Location: ./misc/no_quiz_yet.php");
                            ?>
                        <?php } ?>
                    </div>

                    <div class="navigation-buttons" style="position: fixed; bottom: 0; right: 0; padding: 10px;">
                        <button type="button" class="btn btn-xlg btn-primary p-3 pl-4 pr-4" id="nextQuestionBtn">Next
                            Question</button>
                        <input name="submitQuizButton" type="submit" value="Submit"
                            class="btn btn-xlg btn-primary p-3 pl-4 pr-4" id="submitAnswerFrmBtn"
                            style="display: none;">

                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const questions = document.querySelectorAll('.question');
        let currentQuestionIndex = 0;

        function showQuestion(index) {
            questions.forEach((question, i) => {
                question.style.display = i === index ? 'block' : 'none';
            });
        }

        function selectOption(option) {
            const optionText = option.textContent.trim();
            const question = option.closest('.question');
            const questionId = question.getAttribute('data-question-id');

            question.querySelectorAll('.option-box').forEach((opt) => {
                opt.classList.remove('selected');
            });
            option.classList.add('selected');
            document.getElementById('response_' + questionId).value = optionText;
        }

        const timeLimit = parseInt(document.getElementById('timeExamLimit').value);
        let timeRemaining = timeLimit * 60; // Convert minutes to seconds
        let timerInterval;

        function updateTimerDisplay() {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            document.getElementById('txt').value = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function submitQuizAutomatically() {
            clearInterval(timerInterval);
            document.getElementById('quizform').submit();
        }


        function updateButtonLabel() {
            const buttonText = currentQuestionIndex < questions.length - 1 ? 'Next Question' : 'Submit';
            document.getElementById('nextQuestionBtn').innerText = buttonText;
        }

        function nextQuestion() {
            currentQuestionIndex++;
            if (currentQuestionIndex < questions.length) {
                showQuestion(currentQuestionIndex);
                updateButtonLabel();
            } else {
                submitQuizAutomatically(); // Automatically submit the quiz when all questions are answered
            }
        }

        timerInterval = setInterval(function () {
            if (timeRemaining > 0) {
                timeRemaining--;
                updateTimerDisplay();
            } else {
                submitQuizAutomatically();
            }
        }, 1000);

        document.getElementById('nextQuestionBtn').addEventListener('click', nextQuestion);

        showQuestion(currentQuestionIndex);
        updateButtonLabel();
    </script>

    <script type="text/javascript">
        function preventBack() {
            window.history.forward();
        }
        setTimeout("preventBack()", 0);
        window.onunload = function () {
            null
        };
    </script>

</body>

</html>