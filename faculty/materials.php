<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_POST['delete_video'])) {
    $delete_id = $_POST['video_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $verify_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
    $verify_video->execute([$delete_id]);
    if ($verify_video->rowCount() > 0) {
        $delete_video_thumb = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
        $delete_video_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/' . $fetch_thumb['thumb']);
        $delete_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
        $delete_video->execute([$delete_id]);
        $fetch_video = $delete_video->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/' . $fetch_video['video']);
        $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE content_id = ?");
        $delete_likes->execute([$delete_id]);
        $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE content_id = ?");
        $delete_comments->execute([$delete_id]);
        $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
        $delete_content->execute([$delete_id]);
        $message[] = 'video deleted!';
    } else {
        $message[] = 'video already deleted!';
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

    <section class="contents">

        <h1 class="heading">your materials</h1>

        <div class="box-container">

            <div class="box" style="text-align: center;">
                <h3 class="title" style="margin-bottom: .5rem;">create new material</h3>
                <a href="add_content.php" class="btn">add content</a>
            </div>

            <?php
            $select_videos = $conn->prepare("SELECT lm.*, l.teacher_id 
            FROM tbl_learningmaterials lm
            INNER JOIN tbl_lessons l ON lm.lesson_id = l.lesson_id
            WHERE l.teacher_id = ? 
            ORDER BY lm.date_created DESC");
            $select_videos->execute([$teacher_id]);
            if ($select_videos->rowCount() > 0) {
                while ($fecth_videos = $select_videos->fetch(PDO::FETCH_ASSOC)) {
                    $video_id = $fecth_videos['material_id'];
                    ?>
                    <div class="box">
                        <div class="flex">
                            <div><i class="fas fa-dot-circle" style="<?php if ($fecth_videos['status'] == 'active') {
                                echo 'color:limegreen';
                            } else {
                                echo 'color:red';
                            } ?>"></i><span style="<?php if ($fecth_videos['status'] == 'active') {
                                 echo 'color:limegreen';
                             } else {
                                 echo 'color:red';
                             } ?>">
                                    <?= $fecth_videos['status']; ?>
                                </span></div>
                            <div><i class="fas fa-calendar"></i><span>
                                    <?= $fecth_videos['date_created']; ?>
                                </span></div>
                        </div>
                        <img src="../tmp/<?= $fecth_videos['thumbnail']; ?>" class="thumb" alt="">
                        <h3 class="title">
                            <?= $fecth_videos['material_title']; ?>
                        </h3>
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
                            <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
                            <input type="submit" value="delete" class="delete-btn"
                                onclick="return confirm('delete this video?');" name="delete_video">
                        </form>
                        <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">view content</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no contents added yet!</p>';
            }
            ?>

        </div>

    </section>


    <script src="../scripts/script.js"></script>

</body>

</html>