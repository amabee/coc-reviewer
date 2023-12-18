<?php
session_start();
include '../includes/connection.php';

if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_POST['submit'])) {
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $lessons = filter_var($_POST['lessons'], FILTER_SANITIZE_STRING);
    $quiz_type = filter_var($_POST['quiz_type'], FILTER_SANITIZE_STRING);
    $retryAfter = filter_var($_POST['retryAfter'], FILTER_SANITIZE_STRING);
    $retryAfterSeconds = $retryAfter * 3600;

    $add_quiz = $conn->prepare("INSERT INTO `tbl_quiz` (`lesson_id`, `quiz_title`, `quiz_description`, `quiz_type`, `retryAfter`, `quiz_created`, `status`) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
    $add_quiz->execute([$lessons, $title, $description, $quiz_type, $retryAfterSeconds, $status]);

    $message[] = 'New quiz added!';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <section class="video-form">

        <h1 class="heading">create quiz</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <p>Quiz status <span>*</span></p>
            <select name="status" class="box" required>
                <option value="" selected disabled>-- select status</option>
                <option value="active">active</option>
                <option value="deactive">inactive</option>
            </select>
            <p>Quiz title <span>*</span></p>
            <input type="text" name="title" maxlength="100" required placeholder="enter Quiz title" class="box">
            <p>Quiz description <span>*</span></p>
            <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30"
                Quiz="10"></textarea>
            <p>Quiz lesson <span>*</span></p>
            <select name="lessons" class="box" required>
                <option value="" disabled selected>--select lesson</option>
                <?php
                $select_lessons = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ?");
                $select_lessons->execute([$teacher_id]);
                if ($select_lessons->rowCount() > 0) {
                    while ($fetch_lessons = $select_lessons->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?= $fetch_lessons['lesson_id']; ?>">
                            <?= $fetch_lessons['lesson_title']; ?>
                        </option>
                        <?php
                    }
                    ?>
                    <?php
                } else {
                    echo '<option value="" disabled>no quizzes made yet!</option>';
                }
                ?>
            </select>
            <p>Quiz Type <span>*</span></p>
            <select name="quiz_type" class="box" required>
                <option value="" disabled selected>--Select Quiz Type</option>
                <option value="pre-test">Pre-Test</option>
                <option value="post-test">Post-Test</option>
            </select>
            <p>If post-test failed, Retry After (in Hour): <span>*</span></p>

            <input type="text" name="retryAfter" id="retryAfter" required placeholder="Enter Retry Timer in Hour" class="box">
            <input type="submit" value="Create Quiz" name="submit" class="btn">

        </form>

    </section>
    <script>
        const input = document.getElementById('retryAfter');
        const numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        input.addEventListener('keyup', function (event) {
            if (numbers.indexOf(event.key) == -1) {
                input.value = input.value.replace(/[^0-9]/g, '');
            } 
        });
    </script>
    <script src="../scripts/script.js"></script>


</body>

</html>