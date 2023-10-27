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

$select_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `tbl_bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <section class="quick-select">

        <h1 class="heading">quick options</h1>

        <div class="box-container">

            <?php
            if ($user_id != '') {
                ?>
                <div class="box">
                    <h3 class="title">Comments And Bookmarks</h3>
                    <p>Total Comments : <span>
                            <?= $total_comments; ?>
                        </span></p>
                    <a href="comments.php" class="inline-btn">view comments</a>
                    <p>Saved Materials : <span>
                            <?= $total_bookmarked; ?>
                        </span></p>
                    <a href="bookmark.php" class="inline-btn">view bookmark</a>
                </div>
                <?php
            } else {
                ?>
                <div class="box" style="text-align: center;">
                    <h3 class="title">please login or register</h3>
                    <div class="flex-btn" style="padding-top: .5rem;">
                        <a href="../index.php" class="option-btn">login</a>
                        <a href="register.php" class="option-btn">register</a>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="box">
                <h3 class="title">Categories</h3>
                <div class="flex">
                    <a href="search_course.php?"><i class="fa-solid fa-gavel"></i><span>Criminal Law and
                            Jurisprudence</span></a>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i><span>Law Enforcement
                            Administration</span></a>
                    <a href="#"><i class="fas fa-chart-simple"></i><span>Forensics/Criminalistics</span></a>
                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i><span>Crime Detection and
                            Investigation</span></a>
                    <a href="#"><i class="fa-solid fa-people-robbery"></i><span>Sociology of Crimes and
                            Ethics</span></a>
                    <a href="#"><i class="fa-solid fa-handcuffs"></i><span>Correctional Administration</span></a>
                </div>
            </div>
        </div>

    </section>

    <!-- quick select section ends -->

    <!-- courses section starts  -->

    <section class="courses">

        <h1 class="heading">Latest Lessons</h1>

        <div class="box-container">

            <?php
            $select_courses = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE status = ? ORDER BY date DESC LIMIT 6");
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

        <div class="more-btn">
            <a href="lessons.php" class="inline-option-btn">view more</a>
        </div>

    </section>

    <!-- courses section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>