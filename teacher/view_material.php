<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:materials.php');
}

if (isset($_POST['delete_material'])) {

    $delete_id = $_POST['material_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $delete_material_thumb = $conn->prepare("SELECT thumbnail FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
    $delete_material_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_material_thumb->fetch(PDO::FETCH_ASSOC);
    unlink('../tmp/' . $fetch_thumb['thumbnail']);

    $delete_material = $conn->prepare("SELECT file FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
    $delete_material->execute([$delete_id]);
    $fetch_material = $delete_material->fetch(PDO::FETCH_ASSOC);
    unlink('../tmp/' . $fetch_material['file']);

    $delete_comments = $conn->prepare("DELETE FROM `tbl_comments` WHERE material_id = ?");
    $delete_comments->execute([$delete_id]);

    $delete_content = $conn->prepare("DELETE FROM `tbl_learningmaterials` WHERE material_id = ?");
    $delete_content->execute([$delete_id]);
    header('location:materials.php');

}

if (isset($_POST['delete_comment'])) {

    $delete_id = $_POST['comment_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ?");
    $verify_comment->execute([$delete_id]);

    if ($verify_comment->rowCount() > 0) {
        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
        $delete_comment->execute([$delete_id]);
        $message[] = 'comment deleted successfully!';
    } else {
        $message[] = 'comment already deleted!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view content</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>


    <section class="view-content">

        <?php
        $select_content = $conn->prepare("SELECT LM.* 
    FROM `tbl_learningmaterials` LM
    JOIN `tbl_lessons` L ON LM.lesson_id = L.lesson_id
    WHERE L.teacher_id = ? AND LM.material_id = ?");

        $select_content->execute([$teacher_id, $get_id]);


        if ($select_content->rowCount() > 0) {
            while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                $material_id = $fetch_content['material_id'];

                $count_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE teacher_id = ? AND material_id = ?");
                $count_comments->execute([$teacher_id, $material_id]);
                $total_comments = $count_comments->rowCount();
                ?>
                <div class="container">
                    <iframe src="../tmp/<?= $fetch_content['file']; ?>" frameborder="0" width='100%' height="700px"
                        crossorigin="anonymous" id="pdfFrame"></iframe>
                    <div class="date"><i class="fas fa-calendar"></i><span>
                            <?= $fetch_content['date_created']; ?>
                        </span></div>
                    <h3 class="title">
                        <?= $fetch_content['material_title']; ?>
                    </h3>
                    <div class="flex">
                        <div><i class="fas fa-comment"></i><span>
                                <?= $total_comments; ?>
                            </span></div>
                    </div>
                    <div class="description">
                        <?= $fetch_content['material_description']; ?>
                    </div>
                    <form action="" method="post">
                        <div class="flex-btn">
                            <input type="hidden" name="material_id" value="<?= $material_id; ?>">
                            <a href="update_material.php?get_id=<?= $material_id; ?>" class="option-btn">update</a>
                            <input type="submit" value="remove" class="delete-btn"
                                onclick="return confirm('Remove this material?');" name="delete_material">
                        </div>
                    </form>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">no materials added yet! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add materials</a></p>';
        }

        ?>

    </section>

    <section class="comments">

        <h1 class="heading">user comments</h1>


        <div class="show-comments">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE material_id = ?");
            $select_comments->execute([$get_id]);
            if ($select_comments->rowCount() > 0) {
                while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    $select_commentor = $conn->prepare("SELECT * FROM `tbl_students` WHERE id = ?");
                    $select_commentor->execute([$fetch_comment['user_id']]);
                    $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="box">
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
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="comment_id" value="<?= $fetch_comment['comment_id']; ?>">
                            <button type="submit" name="delete_comment" class="inline-delete-btn"
                                onclick="return confirm('remove this comment?');">remove comment</button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no comments added yet!</p>';
            }
            ?>
        </div>

    </section>



    <script src="scripts/script.js"></script>

    <script>
        
        function printContent() {
            var iframe = document.getElementById('pdfFrame').contentWindow;
            iframe.print();
        }
    </script>

</body>

</html>