<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

$select_teacher = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE teacher_id = ? LIMIT 1");
$select_teacher->execute([$teacher_id]);
$fetch_teacher = $select_teacher->fetch(PDO::FETCH_ASSOC);

$prev_pass = $fetch_teacher['password'];

$default_pass = sha1("password");

if ($prev_pass === $default_pass) {
    header('location:update.php');
}

if (isset($_POST['delete'])) {
    try {
        $delete_id = $_POST['lesson_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_playlist = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_id = ? AND teacher_id = ? LIMIT 1");
        $verify_playlist->execute([$delete_id, $teacher_id]);

        if ($verify_playlist->rowCount() > 0) {

            $delete_playlist_thumb = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE lesson_id = ? LIMIT 1");
            $delete_playlist_thumb->execute([$delete_id]);
            $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);

            $thumb_path = '../tmp/' . $fetch_thumb['thumb'];
            if (!file_exists($thumb_path) && !unlink($thumb_path)) {
                $message[] = 'Error deleting lesson thumbnail file!';
            }
            $delete_bookmark = $conn->prepare("DELETE FROM `tbl_bookmark` WHERE lesson_id = ?");
            $delete_bookmark->execute([$delete_id]);

            $delete_playlist = $conn->prepare("DELETE FROM `tbl_lessons` WHERE lesson_id = ?");
            $delete_playlist->execute([$delete_id]);
            $message[] = 'Lesson deleted!';

        } else {
            $message[] = 'Lesson already deleted!';
        }
    } catch (PDOException $ex) {
        $message[] = $ex->getMessage();
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

    <?php include '../includes/teacher_header.php'; ?>

    <section class="playlists">

        <h1 class="heading">Added Lessons</h1>

        <div class="box-container">

            <div class="box" style="text-align: center;">
                <h3 class="title" style="margin-bottom: .5rem;">create new lesson</h3>
                <a href="add_lesson.php" class="btn">add lesson</a>
            </div>

            <?php
            $itemsPerPage = 3;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $itemsPerPage;

            $countQuery = $conn->prepare("SELECT COUNT(*) FROM `tbl_lessons` WHERE teacher_id = ?");
            $countQuery->execute([$teacher_id]);
            $totalItems = $countQuery->fetchColumn();

            $select_playlist = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ? ORDER BY date DESC LIMIT $offset, $itemsPerPage");
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
                            <input type="hidden" name="lesson_id" value="<?= $playlist_id; ?>">
                            <a href="update_lesson.php?get_id=<?= $playlist_id; ?>" class="option-btn">update</a>
                            <input type="submit" value="delete" class="delete-btn"
                                onclick="return confirm('delete this playlist?');" name="delete">
                        </form>
                        <a href="view_lesson.php?get_id=<?= $playlist_id; ?>" class="btn">view lesson</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no lessons added yet!</p>';
            }
            ?>

    </section>

    <?php
    // Display pagination links
    $totalPages = ceil($totalItems / $itemsPerPage);

    echo '<div class="pagination">';
    if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="?page=' . $i . '" class="' . ($page == $i ? 'active' : '') . '">' . $i . '</a>';
    }
    if ($page < $totalPages) {
        echo '<a href="?page=' . ($page + 1) . '">Next</a>';
    }
    echo '</div>';
    ?>


    <script src="../scripts/script.js"></script>

    <script>
        document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
            if (content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
        });
    </script>

</body>

</html>