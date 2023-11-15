<?php
include '../includes/connection.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
} else {
    $admin_id = '';
    header('location:login.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/admin_header.php'; ?>

    <section class="dashboard">

        <h1 class="heading">dashboard</h1>

        <div class="box-container">

            <div class="box">
                <h3>welcome!</h3>
                <p>
                    <?= $fetch_profile['firstname']; ?>
                    <?= $fetch_profile['lastname']; ?>
                </p>
                <a href="profile.php" class="btn">view profile</a>
            </div>

            <div class="box">
                <!-- <h3>
                    <?= $total_contents; ?>
                </h3> -->
                <p>total contents</p>
                <a href="add_content.php" class="btn">add new content</a>
            </div>

            <div class="box">
                <!-- <h3>
                    <?= $total_lessons; ?>
                </h3> -->
                <p>total Lessons</p>
                <a href="add_playlist.php" class="btn">add new Lesson</a>
            </div>

            <div class="box">
                <!-- <h3>
                    <?= $total_comments; ?>
                </h3> -->
                <p>total comments</p>
                <a href="comments.php" class="btn">view comments</a>
            </div>
        </div>

    </section>


    <script src="../scripts/script.js"></script>

</body>

</html>