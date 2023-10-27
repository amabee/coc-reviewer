<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (empty($_SESSION['user_id']) || (empty($_COOKIE['user_id']))) {
    header("Location: ../unauthorized.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>courses</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <?php include '../includes/user_header.php'; ?>


    <!-- courses section starts  -->

    <section class="courses">

        <h1 class="heading">search results</h1>

        <div class="box-container">

            <?php
            if (isset($_POST['search_lesson']) or isset($_POST['search_lesson_btn'])) {
                $search_lesson = $_POST['search_lesson'];
                $select_lessons = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_title LIKE '%{$search_lesson}%' AND status = ?");
                $select_lessons->execute(['active']);
                if ($select_lessons->rowCount() > 0) {
                    while ($fetch_course = $select_lessons->fetch(PDO::FETCH_ASSOC)) {
                        $course_id = $fetch_course['lesson_id'];

                        $select_tutor = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE teacher_id = ?");
                        $select_tutor->execute([$fetch_course['teacher_id']]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="box">
                            <div class="tutor">
                                <img src="../tmp/<?= $fetch_tutor['image']; ?>" alt="">
                                <div>
                                    <h3>
                                        <?= $fetch_tutor['firstname']; ?>
                                        <?= $fetch_tutor['lastname']; ?>
                                    </h3>
                                    <span>
                                        <?= $fetch_course['date']; ?>
                                    </span>
                                </div>
                            </div>
                            <img src="../tmp/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
                            <h3 class="title">
                                <?= $fetch_course['lesson_title']; ?>
                            </h3>
                            <a href="lessons.php?get_id=<?= $course_id; ?>" class="inline-btn">view playlist</a>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="empty">no courses found!</p>';
                }
            } else {
                echo '<p class="empty">please search something!</p>';
            }
            ?>

        </div>

    </section>

    <!-- courses section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>