<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_POST['submit'])) {
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $playlist = $_POST['playlist'];
    $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);

    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename_thumb = date('dmYHis') . '.' . $thumb_ext;
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_folder = '../tmp/' . $rename_thumb;

    $video = $_FILES['video']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = date('dmYHis') . '.' . $video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../tmp/' . $rename_video;

    if ($thumb_size > 2000000) {
        $message[] = 'Image size is too large!';
    } else {
        $add_material = $conn->prepare("INSERT INTO `tbl_learningmaterials` (`lesson_id`, `material_title`, `material_description`, `file`, `thumbnail`, `date_created`, `status`) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
        $add_material->execute([$playlist, $title, $description, $rename_video, $rename_thumb, $status]);
        move_uploaded_file($thumb_tmp_name, $thumb_folder);
        move_uploaded_file($video_tmp_name, $video_folder);
        $message[] = 'New material uploaded!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/admin_header.php'; ?>

    <section class="video-form">

        <h1 class="heading">upload content</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <p>material status <span>*</span></p>
            <select name="status" class="box" required>
                <option value="" selected disabled>-- select status</option>
                <option value="active">active</option>
                <option value="deactive">deactive</option>
            </select>
            <p>material title <span>*</span></p>
            <input type="text" name="title" maxlength="100" required placeholder="enter material title" class="box">
            <p>material description <span>*</span></p>
            <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30"
                rows="10"></textarea>
            <p>material lesson <span>*</span></p>
            <select name="playlist" class="box" required>
                <option value="" disabled selected>--select lesson</option>
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
                    echo '<option value="" disabled>no material created yet!</option>';
                }
                ?>
            </select>
            <p>select thumbnail <span>*</span></p>
            <input type="file" name="thumb" accept="image/*" required class="box">
            <p>select file <span>*</span></p>
            <input type="file" name="video" accept="application/pdf" required class="box">
                <input type="submit" value="Upload PDF" name="submit" class="btn">

        </form>

    </section>

    <script src="../scripts/script.js"></script>

</body>

</html>