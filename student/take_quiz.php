<?php

session_start();
include '../includes/connection.php';

if (empty($_SESSION['user_id'])) {
    header("Location: ../unauthorized.php");
    exit();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

$get_id = $_COOKIE['get_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- PDF JS CDN LINK -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"
        integrity="sha512-Z8CqofpIcnJN80feS2uccz+pXWgZzeKxDsDNMD/dJ6997/LSRY+W4NmEt9acwR+Gt9OHN0kkI1CTianCwoqcjQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- sweet alert -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.location.href.indexOf('get_id=') > -1) {
                var newUrl = window.location.href.replace(/[\?&]get_id=([^&#]*)/, '');
                window.history.replaceState({}, document.title, newUrl);
            }
        });
    </script>

</head>

<body>

    <?php include '../includes/user_header.php'; ?>


    <section class="watch-video">
        <div class="video-details">
            <iframe src="answer_quiz.php?quiz_id=<?= $get_id ?>" width='100%' height="700px" crossorigin="anonymous"
                frameborder="0"></iframe>

        </div>
    </section>


    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>