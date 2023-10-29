<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
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
    <title>Lessons</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <!-- courses section starts  -->

    <section class="courses">

        <h1 class="heading">all lessons</h1>

        <div class="box-container">

            <?php
            $select_courses = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE status = ? ORDER BY date DESC");
            $select_courses->execute(['active']);
            if ($select_courses->rowCount() > 0) {
                while ($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
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
                        <a href="materials.php?get_id=<?= $course_id; ?>" class="inline-btn">view materials</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no lessons added yet!</p>';
            }
            ?>

        </div>

    </section>

    <!-- courses section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>