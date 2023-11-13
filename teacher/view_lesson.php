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
    header('location:lessons.php');
}

if (isset($_POST['delete_playlist'])) {
    $delete_id = $_POST['lesson_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $delete_playlist_thumb = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_id = ? LIMIT 1");
    $delete_playlist_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
    unlink('../tmp/' . $fetch_thumb['thumb']);
    $delete_bookmark = $conn->prepare("DELETE FROM `tbl_bookmark` WHERE lesson_id = ?");
    $delete_bookmark->execute([$delete_id]);
    $delete_playlist = $conn->prepare("DELETE FROM `tbl_lessons` WHERE lesson_id = ?");
    $delete_playlist->execute([$delete_id]);
    header('locatin:lessons.php');
}

if (isset($_POST['delete_file'])) {
    $delete_id = $_POST['material_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $verify_file = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
    $verify_file->execute([$delete_id]);
    if ($verify_file->rowCount() > 0) {
        $delete_file_thumb = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
        $delete_file_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_file_thumb->fetch(PDO::FETCH_ASSOC);
        unlink('../tmp/' . $fetch_thumb['thumbnail']);
        $delete_file = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
        $delete_file->execute([$delete_id]);
        $fetch_video = $delete_file->fetch(PDO::FETCH_ASSOC);
        unlink('../tmp/' . $fetch_video['file']);
        $delete_comments = $conn->prepare("DELETE FROM `tbl_comments` WHERE material_id = ?");
        $delete_comments->execute([$delete_id]);
        $delete_content = $conn->prepare("DELETE FROM `tbl_learningmaterials` WHERE material_id = ?");
        $delete_content->execute([$delete_id]);
        $message[] = 'material deleted!';

    } else {

        $message[] = 'material already deleted!';
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist Details</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/admin_header.php'; ?>

    <section class="playlist-details">

        <h1 class="heading">playlist details</h1>

        <?php
        $select_playlist = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_id = ? AND teacher_id = ?");
        $select_playlist->execute([$get_id, $teacher_id]);
        if ($select_playlist->rowCount() > 0) {
            while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                $playlist_id = $fetch_playlist['lesson_id'];
                $count_videos = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE lesson_id = ?");
                $count_videos->execute([$playlist_id]);
                $total_videos = $count_videos->rowCount();
                ?>
                <div class="row">
                    <div class="thumb">
                        <span>
                            <?= $total_videos; ?>
                        </span>
                        <img src="../tmp/<?= $fetch_playlist['thumb']; ?>" alt="">
                    </div>
                    <div class="details">
                        <h3 class="title">
                            <?= $fetch_playlist['lesson_title']; ?>
                        </h3>
                        <div class="date"><i class="fas fa-calendar"></i><span>
                                <?= $fetch_playlist['date']; ?>
                            </span></div>
                        <div class="description">
                            <?= $fetch_playlist['lesson_desc']; ?>
                        </div>
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
                            <a href="update_lesson.php?get_id=<?= $playlist_id; ?>" class="option-btn">update lesson</a>
                            <input type="submit" value="delete lesson" class="delete-btn"
                                onclick="return confirm('delete this playlist?');" name="delete">
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p class="empty">no playlist found!</p>';
        }
        ?>

    </section>

    <section class="contents">

        <h1 class="heading">playlist videos</h1>

        <div class="box-container">

            <?php
            $select_videos = $conn->prepare("SELECT lm.*, tl.teacher_id
            FROM tbl_learningmaterials AS lm
            INNER JOIN tbl_lessons AS tl ON lm.lesson_id = tl.lesson_id
            WHERE tl.teacher_id = ? AND lm.lesson_id = ?");
            $select_videos->execute([$teacher_id, $playlist_id]);
            if ($select_videos->rowCount() > 0) {
                while ($fetch_materials = $select_videos->fetch(PDO::FETCH_ASSOC)) {
                    $file_id = $fetch_materials['material_id'];
                    ?>
                    <div class="box">
                        <div class="flex">
                            <div><i class="fas fa-dot-circle" style="<?php if ($fetch_materials['status'] == 'active') {
                                echo 'color:limegreen';
                            } else {
                                echo 'color:red';
                            } ?>"></i><span style="<?php if ($fetch_materials['status'] == 'active') {
                                 echo 'color:limegreen';
                             } else {
                                 echo 'color:red';
                             } ?>">
                                    <?= $fetch_materials['status']; ?>
                                </span></div>
                            <div><i class="fas fa-calendar"></i><span>
                                    <?= $fetch_materials['date_created']; ?>
                                </span></div>
                        </div>
                        <img src="../tmp/<?= $fetch_materials['thumbnail']; ?>" class="thumb" alt="">
                        <h3 class="title">
                            <?= $fetch_materials['material_title']; ?>
                        </h3>
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="material_id" value="<?= $file_id; ?>">
                            <a href="update_content.php?get_id=<?= $file_id; ?>" class="option-btn">update</a>
                            <input type="submit" value="Remove" class="delete-btn"
                                onclick="return confirm('remove this lesson?');" name="delete_file">
                        </form>
                        <a href="view_material.php?get_id=<?= $file_id; ?>" class="btn">Read File</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no materials added yet! <a href="add_materials.php" class="btn" style="margin-top: 1.5rem;">add materials</a></p>';
            }
            ?>

        </div>

    </section>



    <script src="scripts/script.js"></script>

</body>

</html>