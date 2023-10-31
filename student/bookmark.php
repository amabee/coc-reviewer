<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bookmarks</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <section class="courses">

        <h1 class="heading">bookmarked lessons</h1>

        <div class="box-container">

            <?php
            $select_bookmark = $conn->prepare("SELECT * FROM `tbl_bookmark` WHERE user_id = ?");
            $select_bookmark->execute([$user_id]);
            if ($select_bookmark->rowCount() > 0) {
                while ($fetch_bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC)) {
                    $select_courses = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_id = ? AND status = ? ORDER BY date DESC");
                    $select_courses->execute([$fetch_bookmark['lesson_id'], 'active']);
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
                                <a href="materials.php?get_id=<?= $course_id; ?>" class="inline-btn">view lesson</a>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="empty">no lessons found!</p>';
                    }
                }
            } else {
                echo '<p class="empty">nothing bookmarked yet!</p>';
            }
            ?>

        </div>

    </section>


    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>
    
</body>

</html>