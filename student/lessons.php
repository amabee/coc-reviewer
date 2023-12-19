<?php
session_start();
include '../includes/connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (empty($_SESSION['user_id'])) {
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

    <!-- sweet alert -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <!-- courses section starts  -->

    <section class="courses">

        <h1 class="heading">all lessons</h1>

        <div class="box-container">

            <?php
            $select_courses = $conn->prepare("SELECT tbl_classlessons.lesson_id, tbl_studentclasses.section_name, tbl_studentclasses.student_id, tbl_lessons.status, 
            tbl_lessons.teacher_id, tbl_lessons.date, tbl_lessons.lesson_title, tbl_lessons.thumb
            FROM tbl_studentclasses
            INNER JOIN tbl_classlessons ON tbl_classlessons.section_name = tbl_studentclasses.section_name
            INNER JOIN tbl_lessons ON tbl_classlessons.lesson_id = tbl_lessons.lesson_id 
            WHERE tbl_lessons.status = ? AND tbl_studentclasses.student_id = ? ORDER BY date DESC;
            ");
            $select_courses->execute(['active', $user_id]);
            if ($select_courses->rowCount() > 0) {
                while ($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                    $course_id = $fetch_course['lesson_id'];
                    $select_tutor = $conn->prepare("
                                        SELECT * FROM tbl_teachers
                                        INNER JOIN tbl_section ON tbl_teachers.teacher_id = tbl_section.teacher_id
                                        WHERE tbl_teachers.teacher_id = ?;
                                    ");

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
                        <a href="materials.php?get_id=<?= $course_id; ?>" class="inline-btn"
                            onclick="setTempCookie('get_materialsPage_id', <?= $course_id ?>)">view materials</a>
                        <script>
                            function setTempCookie(cookieName, cookieValue) {
                                document.cookie = cookieName + '=' + cookieValue + '; path=/';
                            }
                        </script>
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