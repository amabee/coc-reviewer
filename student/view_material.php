<?php

session_start();
include '../includes/connection.php';

if (empty($_SESSION['user_id']) || (empty($_COOKIE['user_id']))) {
    header("Location: ../unauthorized.php");
    exit();
}

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:home.php');
}


if (isset($_POST['add_comment'])) {
    if ($user_id != '') {
        $comment_box = $_POST['comment_box'];
        $comment_box = filter_var($comment_box, FILTER_SANITIZE_STRING);
        $content_id = $_POST['content_id'];
        $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);

        $select_content = $conn->prepare("SELECT L.teacher_id
                                FROM `tbl_learningmaterials` LM
                                JOIN `tbl_lessons` L ON LM.lesson_id = L.lesson_id
                                WHERE LM.material_id = ? LIMIT 1");

        $select_content->execute([$content_id]);
        $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);

        $tutor_id = $fetch_content['teacher_id'];

        if ($select_content->rowCount() > 0) {

            $insert_comment = $conn->prepare("INSERT INTO `tbl_comments`(`material_id`, `user_id`, `teacher_id`, `comment`, `date`) VALUES(?,?,?,?,NOW())");
            $insert_comment->execute([$content_id, $user_id, $tutor_id, $comment_box]);
            $message[] = 'New comment added!';
        } else {
            $message[] = 'Something went wrong!';
        }
    } else {
        $message[] = 'Please log in first!';
    }
}

if (isset($_POST['delete_comment'])) {

    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_comment = $conn->prepare("SELECT * FROM `tbl_comments` WHERE comment_id = ?");
    $verify_comment->execute([$delete_id]);

    if ($verify_comment->rowCount() > 0) {
        $delete_comment = $conn->prepare("DELETE FROM `tbl_comments` WHERE comment_id = ?");
        $delete_comment->execute([$delete_id]);
        $message[] = 'comment deleted successfully!';
    } else {
        $message[] = 'comment already deleted!';
    }

}

if (isset($_POST['update_now'])) {

    $update_id = $_POST['update_id'];
    $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
    $update_box = $_POST['update_box'];
    $update_box = filter_var($update_box, FILTER_SANITIZE_STRING);

    $verify_comment = $conn->prepare("SELECT * FROM `tbl_comments` WHERE comment_id = ? AND comment = ?");
    $verify_comment->execute([$update_id, $update_box]);

    if ($verify_comment->rowCount() > 0) {
        $message[] = 'comment already added!';
    } else {
        $update_comment = $conn->prepare("UPDATE `tbl_comments` SET comment = ? WHERE comment_id = ?");
        $update_comment->execute([$update_box, $update_id]);
        $message[] = 'comment edited successfully!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- PDF JS CDN LINK -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"
        integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <?php
    if (isset($_POST['edit_comment'])) {
        $edit_id = $_POST['comment_id'];
        $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);
        $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? LIMIT 1");
        $verify_comment->execute([$edit_id]);
        if ($verify_comment->rowCount() > 0) {
            $fetch_edit_comment = $verify_comment->fetch(PDO::FETCH_ASSOC);
            ?>
            <section class="edit-comment">
                <h1 class="heading">edit comment</h1>
                <form action="" method="post">
                    <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['id']; ?>">
                    <textarea name="update_box" class="box" maxlength="1000" required placeholder="please enter your comment"
                        cols="30" rows="10"><?= $fetch_edit_comment['comment']; ?></textarea>
                    <div class="flex">
                        <a href="watch_video.php?get_id=<?= $get_id; ?>" class="inline-option-btn">cancel edit</a>
                        <input type="submit" value="update now" name="update_now" class="inline-btn">
                    </div>
                </form>
            </section>
            <?php
        } else {
            $message[] = 'comment was not found!';
        }
    }
    ?>

    <!-- watch video section starts  -->

    <section class="watch-video">

        <?php

        $select_content = $conn->prepare("SELECT LM.*, T.* FROM `tbl_learningmaterials` LM
        JOIN `tbl_lessons` L ON LM.lesson_id = L.lesson_id
        JOIN `tbl_teachers` T ON L.teacher_id = T.teacher_id
        WHERE LM.material_id = ? AND LM.status = ?");

        $select_content->execute([$get_id, 'active']);
        if ($select_content->rowCount() > 0) {
            while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                $content_id = $fetch_content['material_id'];

                $select_tutor = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE teacher_id = ? LIMIT 1");
                $select_tutor->execute([$fetch_content['teacher_id']]);
                $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="video-details">

                    <iframe src="../tmp/<?= $fetch_content['file']; ?>" frameborder="0" width='100%' height="700px"
                        crossorigin="anonymous"></iframe>

                    <h3 class="title">
                        <?= $fetch_content['material_title']; ?>
                    </h3>
                    <div class="info">
                        <p><i class="fas fa-calendar"></i><span>
                                <?= $fetch_content['date_created']; ?>
                            </span></p>
                    </div>
                    <div class="tutor">
                        <img src="../tmp/<?= $fetch_tutor['image']; ?>" alt="">
                        <div>
                            <h3>
                                <?= $fetch_tutor['firstname']; ?>
                                <?= $fetch_tutor['lastname']; ?>
                            </h3>
                        </div>
                    </div>
                    <form action="" method="post" class="flex">
                        <input type="hidden" name="content_id" value="<?= $content_id; ?>">
                        <a href="lessons.php?get_id=<?= $fetch_content['lesson_id']; ?>" class="inline-btn">view lessons</a>
                        <a href="download_material.php?get_id=<?= $fetch_content['file']; ?>" class="inline-btn">Download
                            Material</a>
                    </form>
                    <div class="description">
                        <p>
                            <?= $fetch_content['material_description']; ?>
                        </p>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">no material added yet!</p>';
        }
        ?>

    </section>

    <!-- watch video section ends -->

    <!-- comments section starts  -->

    <section class="comments">

        <h1 class="heading">add a comment / question</h1>

        <form action="" method="post" class="add-comment">
            <input type="hidden" name="content_id" value="<?= $get_id; ?>">
            <textarea name="comment_box" required placeholder="write your comment..." maxlength="1000" cols="30"
                rows="10"></textarea>
            <input type="submit" value="add comment" name="add_comment" class="inline-btn">
        </form>

        <h1 class="heading">user comments</h1>


        <div class="show-comments">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE material_id = ? ORDER BY date DESC");
            $select_comments->execute([$get_id]);
            if ($select_comments->rowCount() > 0) {
                while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    $select_commentor = $conn->prepare("SELECT * FROM `tbl_users` WHERE id = ?");
                    $select_commentor->execute([$fetch_comment['user_id']]);
                    $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="box" style="<?php if ($fetch_comment['user_id'] == $user_id) {
                        echo 'order:-1;';
                    } ?>">
                        <div class="user">
                            <img src="../tmp/<?= $fetch_commentor['image']; ?>" alt="">
                            <div>
                                <h3>
                                    <?= $fetch_commentor['firstname']; ?>
                                    <?= $fetch_commentor['lastname']; ?>
                                </h3>
                                <span>
                                    <?= $fetch_comment['date']; ?>
                                </span>
                            </div>
                        </div>
                        <p class="text">
                            <?= $fetch_comment['comment']; ?>
                        </p>
                        <?php
                        if ($fetch_comment['user_id'] == $user_id) {
                            ?>
                            <form action="" method="post" class="flex-btn">
                                <input type="hidden" name="comment_id" value="<?= $fetch_comment['comment_id']; ?>">
                                <button type="submit" name="edit_comment" class="inline-option-btn">edit comment</button>
                                <button type="submit" name="delete_comment" class="inline-delete-btn"
                                    onclick="return confirm('delete this comment?');">remove comment</button>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no comments added yet!</p>';
            }
            ?>
        </div>

    </section>

    <!-- comments section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>