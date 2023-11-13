<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:login.php');
}

if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:dashboard.php');
}

if (isset($_POST['update'])) {

    $video_id = $_POST['video_id'];
    $video_id = filter_var($video_id, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $playlist = $_POST['playlist'];
    $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);

    $update_content = $conn->prepare("UPDATE `tbl_learningmaterials` SET material_title = ?, material_description = ?, status = ? WHERE material_id = ?");
    $update_content->execute([$title, $description, $status, $video_id]);

    if (!empty($playlist)) {
        $update_playlist = $conn->prepare("UPDATE `tbl_learningmaterials` SET lesson_id = ? WHERE material_id = ?");
        $update_playlist->execute([$playlist, $video_id]);
    }

    $old_thumb = $_POST['old_thumb'];
    $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $randomBytes = random_bytes(24);
    $uniqueId = bin2hex($randomBytes);
    $rename_thumb = $uniqueId . '.' . $thumb_ext;
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_folder = '../tmp/' . $rename_thumb;

    if (!empty($thumb)) {
        if ($thumb_size > 2000000) {
            $message[] = 'image size is too large!';
        } else {
            $update_thumb = $conn->prepare("UPDATE `tbl_learningmaterials` SET thumbnail = ? WHERE material_id = ?");
            $update_thumb->execute([$rename_thumb, $video_id]);
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            if ($old_thumb != '' and $old_thumb != $rename_thumb) {
                unlink('../tmp/' . $old_thumb);
            }
        }
    }

    $old_video = $_POST['old_video'];
    $old_video = filter_var($old_video, FILTER_SANITIZE_STRING);
    $video = $_FILES['video']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $randomBytes = random_bytes(16);
    $uniqueId = bin2hex($randomBytes);
    $rename_video = $uniqueId . '.' . $video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../tmp/' . $rename_video;

    if (!empty($video)) {
        $update_video = $conn->prepare("UPDATE `tbl_learningmaterials` SET file = ? WHERE material_id = ?");
        $update_video->execute([$rename_video, $video_id]);
        move_uploaded_file($video_tmp_name, $video_folder);
        if ($old_video != '' and $old_video != $rename_video) {
            unlink('../tmp/' . $old_video);
        }
    }

    $message[] = 'material updated!';

}

if (isset($_POST['delete_video'])) {

    $delete_id = $_POST['video_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $delete_video_thumb = $conn->prepare("SELECT thumbnail FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
    $delete_video_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
    unlink('../tmp/' . $fetch_thumb['thumbnail']);

    $delete_video = $conn->prepare("SELECT file FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
    $delete_video->execute([$delete_id]);

    $fetch_video = $delete_video->fetch(PDO::FETCH_ASSOC);
    unlink('../tmp/' . $fetch_video['file']);
    if(!unlink('../tmp/' . $fetch_video['file'])){
        $message[] = 'no such image here!';
    }

    $delete_comments = $conn->prepare("DELETE FROM `tbl_comments` WHERE material_id = ?");
    $delete_comments->execute([$delete_id]);

    $delete_content = $conn->prepare("DELETE FROM `tbl_learningmaterials` WHERE material_id = ?");
    $delete_content->execute([$delete_id]);
    header('location:materials.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update video</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/admin_header.php'; ?>

    <section class="video-form">

        <h1 class="heading">update content</h1>

        <?php

        $select_content = $conn->prepare("SELECT LM.* 
                                          FROM `tbl_learningmaterials` LM
                                          JOIN `tbl_lessons` L ON LM.lesson_id = L.lesson_id
                                           WHERE L.teacher_id = ? AND LM.material_id = ?");

        $select_content->execute([$teacher_id, $get_id]);


        if ($select_content->rowCount() > 0) {
            while ($fecth_videos = $select_content->fetch(PDO::FETCH_ASSOC)) {
                $video_id = $fecth_videos['material_id'];
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="video_id" value="<?= $fecth_videos['material_id']; ?>">
                    <input type="hidden" name="old_thumb" value="<?= $fecth_videos['thumbnail']; ?>">
                    <input type="hidden" name="old_video" value="<?= $fecth_videos['file']; ?>">
                    <p>update status <span>*</span></p>
                    <select name="status" class="box" required>
                        <option value="<?= $fecth_videos['status']; ?>" selected>
                            <?= $fecth_videos['status']; ?>
                        </option>
                        <option value="active">active</option>
                        <option value="inactive">deactivate</option>
                    </select>
                    <p>update title <span>*</span></p>
                    <input type="text" name="title" maxlength="100" required placeholder="enter material title" class="box"
                        value="<?= $fecth_videos['material_title']; ?>">
                    <p>update description <span>*</span></p>
                    <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30"
                        rows="10"><?= $fecth_videos['material_description']; ?></textarea>
                    <p>update lesson</p>
                    <select name="playlist" class="box">
                        <option value="<?= $fecth_videos['lesson_id']; ?>" selected>--select playlist</option>
                        <?php
                        $select_playlists = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ?");
                        $select_playlists->execute([$teacher_id]);
                        if ($select_playlists->rowCount() > 0) {
                            while ($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $fetch_playlist['lesson_id']; ?>">
                                    <?= $fetch_playlist['lesson_title']; ?>
                                </option>
                                <?php
                            }
                            ?>
                            <?php
                        } else {
                            echo '<option value="" disabled>no lesson created yet!</option>';
                        }
                        ?>
                    </select>
                    <img src="../tmp/<?= $fecth_videos['thumbnail']; ?>" alt="">
                    <p>update thumbnail</p>
                    <input type="file" name="thumb" accept="image/*" class="box">
                    <iframe src="../tmp/<?= $fecth_videos['file']; ?>" frameborder="" width="100%" height="700px"></iframe>
                    <p>update file</p>
                    <input type="file" name="video" accept="application/pdf">
                    <input type="submit" value="update content" name="update" class="btn">
                    <div class="flex-btn">
                        <a href="view_content.php?get_id=<?= $video_id; ?>" class="option-btn">view content</a>
                        <input type="submit" value="delete content" name="delete_video" class="delete-btn">
                    </div>
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">material not found! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add material</a></p>';
        }
        ?>

    </section>


    <script src="scripts/script.js"></script>

</body>

</html>