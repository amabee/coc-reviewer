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

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:home.php');
}

if (isset($_POST['save_list'])) {

    if ($user_id != '') {

        $list_id = $_POST['list_id'];
        $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

        $select_list = $conn->prepare("SELECT * FROM `tbl_bookmark` WHERE user_id = ? AND lesson_id = ?");
        $select_list->execute([$user_id, $list_id]);

        if ($select_list->rowCount() > 0) {
            $remove_bookmark = $conn->prepare("DELETE FROM `tbl_bookmark` WHERE user_id = ? AND lesson_id = ?");
            $remove_bookmark->execute([$user_id, $list_id]);
            $message[] = 'playlist removed!';
        } else {
            $insert_bookmark = $conn->prepare("INSERT INTO `tbl_bookmark`(user_id, lesson_id) VALUES(?,?)");
            $insert_bookmark->execute([$user_id, $list_id]);
            $message[] = 'lesson saved!';
        }

    } else {
        $message[] = 'please login first!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>playlist</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <!-- lesson section starts  -->

    <section class="playlist">

        <h1 class="heading">lesson details</h1>

        <div class="row">

            <?php
            $select_lesson = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_id = ? and status = ? LIMIT 1");
            $select_lesson->execute([$get_id, 'active']);
            if ($select_lesson->rowCount() > 0) {
                $fetch_lesson = $select_lesson->fetch(PDO::FETCH_ASSOC);

                $lessons_id = $fetch_lesson['lesson_id'];

                $count_materials = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ?");
                $count_materials->execute([$lessons_id]);
                $total_materials = $count_materials->rowCount();

                $select_teacher = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE teacher_id = ? LIMIT 1");
                $select_teacher->execute([$fetch_lesson['teacher_id']]);
                $fetch_tutor = $select_teacher->fetch(PDO::FETCH_ASSOC);

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
                            <!-- <span>
                                <?= $fetch_tutor['profession']; ?>
                            </span> -->
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

    <!-- playlist section ends -->

    <!-- videos container section starts  -->

    <section class="videos-container">

        <h1 class="heading">Lesson Materials</h1>

        <div class="box-container">

            <?php
            $select_content = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE lesson_id = ? AND status = ? ORDER BY date_created DESC");
            $select_content->execute([$get_id, 'active']);
            if ($select_content->rowCount() > 0) {
                while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <a href="view_material.php?get_id=<?= $fetch_content['material_id']; ?>" class="box">
                        <i class="fas fa-play"></i>
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
            ?>

        </div>

    </section>

    <!-- videos container section ends -->



    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>