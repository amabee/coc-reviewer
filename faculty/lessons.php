<?php

include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['lesson_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_playlist = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_id = ? AND teacher_id = ? LIMIT 1");
    $verify_playlist->execute([$delete_id, $teacher_id]);

    if ($verify_playlist->rowCount() > 0) {



        $delete_playlist_thumb = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE id = ? LIMIT 1");
        $delete_playlist_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
        unlink('../tmp/' . $fetch_thumb['thumb']);
        $delete_bookmark = $conn->prepare("DELETE FROM `tbl_bookmark` WHERE lesson_id = ?");
        $delete_bookmark->execute([$delete_id]);
        $delete_playlist = $conn->prepare("DELETE FROM `tbl_lessons` WHERE lesson_id = ?");
        $delete_playlist->execute([$delete_id]);
        $message[] = 'lesson deleted!';
    } else {
        $message[] = 'lesson already deleted!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/admin_header.php'; ?>

    <section class="playlists">

        <h1 class="heading">Added Lessons</h1>

        <div class="box-container">

            <div class="box" style="text-align: center;">
                <h3 class="title" style="margin-bottom: .5rem;">create new lesson</h3>
                <a href="add_lesson.php" class="btn">add lesson</a>
            </div>

            <?php
            $select_playlist = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ? ORDER BY date DESC");
            $select_playlist->execute([$teacher_id]);
            if ($select_playlist->rowCount() > 0) {
                while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                    $playlist_id = $fetch_playlist['lesson_id'];
                    $count_videos = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE lesson_id = ?");
                    $count_videos->execute([$playlist_id]);
                    $total_materials = $count_videos->rowCount();
                    ?>
                    <div class="box">
                        <div class="flex">
                            <div><i class="fas fa-circle-dot" style="<?php if ($fetch_playlist['status'] == 'active') {
                                echo 'color:limegreen';
                            } else {
                                echo 'color:red';
                            } ?>"></i><span style="<?php if ($fetch_playlist['status'] == 'active') {
                                 echo 'color:limegreen';
                             } else {
                                 echo 'color:red';
                             } ?>">
                                    <?= $fetch_playlist['status']; ?>
                                </span></div>
                            <div><i class="fas fa-calendar"></i><span>
                                    <?= $fetch_playlist['date']; ?>
                                </span></div>
                        </div>
                        <div class="thumb">
                            <span>
                                <?= $total_materials; ?>
                            </span>
                            <img src="../tmp/<?= $fetch_playlist['thumb']; ?>" alt="">
                        </div>
                        <h3 class="title">
                            <?= $fetch_playlist['lesson_title']; ?>
                        </h3>
                        <p class="description">
                            <?= $fetch_playlist['lesson_desc']; ?>
                        </p>
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
                            <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="option-btn">update</a>
                            <input type="submit" value="delete" class="delete-btn"
                                onclick="return confirm('delete this playlist?');" name="delete">
                        </form>
                        <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">view playlist</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no lessons added yet!</p>';
            }
            ?>

        </div>

    </section>



    <script src="../scripts/script.js"></script>

    <script>
        document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
            if (content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
        });
    </script>

</body>

</html>