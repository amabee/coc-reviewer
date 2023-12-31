<?php
session_start();
include '../includes/connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (empty($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$select_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `tbl_bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

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
    <link rel="stylesheet" href="../styles/style.css">

      <!-- sweet alert -->

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <section class="profile">

        <h1 class="heading">profile details</h1>

        <div class="details">

            <div class="user">
                <img src="../tmp/<?= $fetch_profile['image']; ?>" alt="">
                <h3>
                    <?= $fetch_profile['firstname']; ?>
                    <?= $fetch_profile['lastname']; ?>
                </h3>
                <p>student</p>
                <a href="update.php" class="inline-btn">update profile</a>
            </div>

            <div class="box-container">

                <div class="box">
                    <div class="flex">
                        <i class="fas fa-bookmark"></i>
                        <div>
                            <h3>
                                <?= $total_bookmarked; ?>
                            </h3>
                            <span>saved lessons</span>
                        </div>
                    </div>
                    <a href="bookmark.php" class="inline-btn">view bookmarks</a>
                </div>

                <div class="box">
                    <div class="flex">
                        <i class="fas fa-comment"></i>
                        <div>
                            <h3>
                                <?= $total_comments; ?>
                            </h3>
                            <span>my comments</span>
                        </div>
                    </div>
                    <a href="comments.php" class="inline-btn">view comments</a>
                </div>

            </div>

        </div>

    </section>

    <!-- profile section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>