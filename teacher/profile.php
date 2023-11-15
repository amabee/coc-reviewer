<?php

include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:login.php');
}

$select_playlists = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ?");
$select_playlists->execute([$teacher_id]);
$total_playlists = $select_playlists->rowCount();

$select_contents = $conn->prepare("SELECT L.teacher_id, LM.* 
   FROM `tbl_learningmaterials` LM
   INNER JOIN `tbl_lessons` L ON LM.lesson_id = L.lesson_id
   WHERE L.teacher_id = ?");
$select_contents->execute([$teacher_id]);
$total_contents = $select_contents->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE teacher_id = ?");
$select_comments->execute([$teacher_id]);
$total_comments = $select_comments->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <section class="tutor-profile" style="min-height: calc(100vh - 19rem);">

        <h1 class="heading">profile details</h1>

        <div class="details">
            <div class="tutor">
                <img src="../tmp/<?= $fetch_profile['image']; ?>" alt="">
                <h3>
                    <?= $fetch_profile['firstname']; ?>
                    <?= $fetch_profile['lastname']; ?>
                </h3>
                <span>
                    <?= $fetch_profile['teacher_id']; ?>
                </span>
                <a href="update.php" class="inline-btn">update profile</a>
            </div>
            <div class="flex">
                <div class="box">
                    <span>
                        <?= $total_playlists; ?>
                    </span>
                    <p>total lessons</p>
                    <a href="lessons.php" class="btn">view lessons</a>
                </div>
                <div class="box">
                    <span>
                        <?= $total_contents; ?>
                    </span>
                    <p>total materials uploaded</p>
                    <a href="materials.php" class="btn">view contents</a>
                </div>
            </div>
        </div>

    </section>

    <script src="../scripts/script.js"></script>

</body>

</html>