<?php
session_start();
include '../includes/connection.php';

if (empty($_SESSION['user_id'])) {
    header("Location: ../unauthorized.php");
    exit();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (!isset($_COOKIE['get_materialsPage_id'])) {
    header('location:home.php');
    exit();
}

$get_id = $_COOKIE['get_materialsPage_id'];


if (isset($_POST['save_list'])) {

    if ($user_id != '') {

        $list_id = $_POST['list_id'];
        $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

        $select_list = $conn->prepare("SELECT * FROM `tbl_bookmark` WHERE user_id = ? AND lesson_id = ?");
        $select_list->execute([$user_id, $list_id]);

        if ($select_list->rowCount() > 0) {
            $remove_bookmark = $conn->prepare("DELETE FROM `tbl_bookmark` WHERE user_id = ? AND lesson_id = ?");
            $remove_bookmark->execute([$user_id, $list_id]);
            $message[] = 'Lesson removed!';
        } else {
            $insert_bookmark = $conn->prepare("INSERT INTO `tbl_bookmark`(user_id, lesson_id) VALUES(?,?)");
            $insert_bookmark->execute([$user_id, $list_id]);
            $message[] = 'Lesson saved!';
        }

    } else {
        $message[] = 'please login first!';
    }
}


$pretest_query = $conn->prepare("SELECT * FROM tbl_quiz WHERE lesson_id = ? AND quiz_type = 'pre-test' AND status = 'active'");
$pretest_query->execute([$get_id]);
$pretest_exists = $pretest_query->rowCount() > 0;

$posttest_query = $conn->prepare("SELECT * FROM tbl_quiz WHERE lesson_id = ? AND quiz_type = 'post-test' AND status = 'active'");
$posttest_query->execute([$get_id]);
$posttest_exists = $posttest_query->rowCount() > 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materials</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.location.href.indexOf('get_id=') > -1) {
                var newUrl = window.location.href.replace(/[\?&]get_id=([^&#]*)/, '');
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>
</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <!-- lesson section starts  -->

    <section class="playlist">

        <h1 class="heading">lesson details</h1>

        <div class="row">

            <?php
            $select_lesson = $conn->prepare("
            SELECT 
                tbl_classlessons.*,
                tbl_section.*,
                tbl_studentclasses.*,
                tbl_lessons.*,
                tbl_teachers.*
            FROM 
                `tbl_classlessons`
            INNER JOIN 
                `tbl_section` ON tbl_classlessons.section_name = tbl_section.section_id
            INNER JOIN 
                `tbl_studentclasses` ON tbl_section.section_id = tbl_studentclasses.section_name
            INNER JOIN 
                `tbl_lessons` ON tbl_classlessons.lesson_id = tbl_lessons.lesson_id
            INNER JOIN 
                `tbl_teachers` ON tbl_teachers.teacher_id = tbl_lessons.teacher_id
            WHERE 
                tbl_classlessons.lesson_id = ?
                AND tbl_lessons.status = 'active' 
                AND tbl_studentclasses.student_id = ?
            LIMIT 1
        ");

            $select_lesson->execute([$get_id, $user_id]);

            if ($select_lesson->rowCount() > 0) {
                $fetch_lesson = $select_lesson->fetch(PDO::FETCH_ASSOC);

                $lessons_id = $fetch_lesson['lesson_id'];

                $count_materials = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE lesson_id = ?");
                $count_materials->execute([$lessons_id]);
                $total_materials = $count_materials->rowCount();
                $fetch_tutor = [
                    'firstname' => $fetch_lesson['firstname'],
                    'lastname' => $fetch_lesson['lastname'],
                    'image' => $fetch_lesson['image'],
                ];

                $select_bookmark = $conn->prepare("SELECT * FROM `tbl_bookmark` WHERE user_id = ? AND lesson_id = ?");
                $select_bookmark->execute([$user_id, $lessons_id]);

                ?>

                <div class="col">
                    <form action="" method="post" class="save-list">
                        <input type="hidden" name="list_id" value="<?= $lessons_id; ?>">
                        <?php
                        if ($select_bookmark->rowCount() > 0) {
                            ?>
                            <button type="submit" name="save_list"><i class="fas fa-bookmark"></i><span>saved</span></button>
                            <?php
                        } else {
                            ?>
                            <button type="submit" name="save_list"><i class="far fa-bookmark"></i><span>Save
                                    Lesson</span></button>
                            <?php
                        }
                        ?>
                    </form>
                    <div class="thumb">
                        <span>
                            <?= $total_materials; ?> Materials
                        </span>
                        <img src="../tmp/<?= $fetch_lesson['thumb']; ?>" alt="">
                    </div>
                </div>

                <div class="col">
                    <div class="tutor">
                        <img src="../tmp/<?= $fetch_tutor['image']; ?>" alt="">
                        <div>
                            <h3>
                                <?= $fetch_tutor['firstname']; ?>
                                <?= $fetch_tutor['lastname']; ?>
                            </h3>
                        </div>
                    </div>
                    <div class="details">
                        <h3>
                            <?= $fetch_lesson['lesson_title']; ?>
                        </h3>
                        <p>
                            <?= $fetch_lesson['lesson_desc']; ?>
                        </p>
                        <div class="date"><i class="fas fa-calendar"></i><span>
                                <?= $fetch_lesson['date']; ?>
                            </span></div>
                    </div>
                </div>

                <?php
            } else {
                echo '<p class="empty">the material was not found!</p>';
            }
            ?>

        </div>

    </section>

    <!-- lessons section ends -->

    <!-- materials container section starts  -->
    <section class="videos-container">
        <h1 class="heading">Lesson Materials</h1>
        <div class="box-container">

            <?php
            // START Pre-test section
            $pretest_query = $conn->prepare("SELECT * FROM tbl_quiz WHERE lesson_id = ? AND quiz_type = 'pre-test' AND status = 'active'");
            $pretest_query->execute([$get_id]);
            $pretest_exists = $pretest_query->rowCount() > 0;

            if ($pretest_exists) {
                $fetch_pretest = $pretest_query->fetch(PDO::FETCH_ASSOC);
                $pretest_id = $fetch_pretest['quiz_id'];

                $pretest_attempt_query = $conn->prepare("SELECT * FROM tbl_quizattempt WHERE student_id = ? AND quiz_id = ? AND attempt_status = 'completed'");
                $pretest_attempt_query->execute([$user_id, $pretest_id]);
                $pretest_attempt_completed = $pretest_attempt_query->rowCount() > 0;

                if (!$pretest_attempt_completed) {
                    ?>
                    <a href="take_quiz.php" class="box" onclick="setTempCookie('quiz_id', <?= $pretest_id; ?>)">
                        <h3>
                            <?= $fetch_pretest['quiz_title']; ?>
                        </h3>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="take_quiz.php" class="box" onclick="setTempCookie('quiz_id', <?= $pretest_id; ?>)">
                        <h3>
                            <?= $fetch_pretest['quiz_title']; ?>
                        </h3>
                    </a>
                    <?php
                }
            } else {
                echo '<p class="empty">Pre-test not available. Materials section disabled.</p>';
            }
            // END Pre-test section
            
            // Display Reading materials section only if pre-test exists and attempt is completed
            if ($pretest_exists && $pretest_attempt_completed) {
                $select_content = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE lesson_id = ? AND status = ? ORDER BY date_created DESC");
                $select_content->execute([$get_id, 'active']);
                if ($select_content->rowCount() > 0) {
                    while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <a href="view_material.php?get_id=<?= $fetch_content['material_id']; ?>" class="box"
                            onclick="setTempCookie('get_id', <?= $fetch_content['material_id']; ?>)">
                            <i class="fa-solid fa-eye"></i>
                            <img src="../tmp/<?= $fetch_content['thumbnail']; ?>" alt="">
                            <h3>
                                <?= $fetch_content['material_title']; ?>
                            </h3>
                        </a>
                        <?php
                    }
                } else {
                    echo '<p class="empty">no materials added yet!</p>';
                }
            } else {
                echo '<p class="empty">Please take the pre-test first before accessing the reading materials!</p>';
            }

            // POST-TEST AREA
            if ($posttest_exists && $pretest_attempt_completed) {
                while ($fetch_postest = $posttest_query->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <a href="take_quiz.php" class="box" onclick="setTempCookie('quiz_id', <?= $fetch_postest['quiz_id']; ?>)">
                        <h3>
                            <?= $fetch_postest['quiz_title']; ?>
                        </h3>
                    </a>
                    <?php
                }
            } else {
                echo '<p class=empty>Post Test Not available right now.</p>';
            }
            // END POST-TEST AREA
            ?>
        </div>
    </section>
    <!-- videos container section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>
    <script>
        function setTempCookie(name, value) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (1 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
        }
    </script>


</body>

</html>