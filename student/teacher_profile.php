<?php

include '../includes/connection.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['tutor_fetch'])) {

    $tutor_email = $_POST['tutor_email'];
    $tutor_email = filter_var($tutor_email, FILTER_SANITIZE_STRING);
    $select_tutor = $conn->prepare('SELECT * FROM `tbl_teachers` WHERE email = ?');
    $select_tutor->execute([$tutor_email]);

    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    $tutor_id = $fetch_tutor['teacher_id'];

    $count_playlists = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ?");
    $count_playlists->execute([$tutor_id]);
    $total_playlists = $count_playlists->rowCount();



    $count_contents = $conn->prepare("SELECT LM.* FROM `tbl_learningmaterials` LM
    JOIN `tbl_lessons` L ON LM.lesson_id = L.lesson_id
    WHERE L.teacher_id = ?");
    $count_contents->execute([$tutor_id]);
    $total_contents = $count_contents->rowCount();


    $count_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE teacher_id = ?");
    $count_comments->execute([$tutor_id]);
    $total_comments = $count_comments->rowCount();

} else {
    header('location:teachers.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tutor's profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <!-- teachers profile section starts  -->

    <section class="tutor-profile">

        <h1 class="heading">profile details</h1>

        <div class="details">
            <div class="tutor">
                <img src="../tmp/<?= $fetch_tutor['image']; ?>" alt="">
                <h3>
                    <?= $fetch_tutor['firstname']; ?>
                    <?= $fetch_tutor['lastname']; ?>
                </h3>
                <!-- <span>
                    <?= $fetch_tutor['profession']; ?>
                </span> -->
            </div>
            <div class="flex">
                <p>total lessons : <span>
                        <?= $total_playlists; ?>
                    </span></p>
                <p>total materials : <span>
                        <?= $total_contents; ?>
                    </span></p>
            </div>
        </div>

    </section>

    <!-- teachers profile section ends -->

    <section class="courses">

        <h1 class="heading">Lessons uploaded</h1>

        <div class="box-container">

            <?php
            $select_courses = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ? AND status = ?");
            $select_courses->execute([$tutor_id, 'active']);
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
                        <a href="lessons.php?get_id=<?= $course_id; ?>" class="inline-btn">view lesson</a>
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