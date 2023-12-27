<?php

session_start();
include '../includes/connection.php';

header('X-Content-Type-Options: nosniff');

if (empty($_SESSION['user_id'])) {
    header("Location: ../unauthorized.php");
    exit();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_COOKIE['get_id'])){
    $get_id = $_COOKIE['get_id'];
}else{
    $get_id = "";
}

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

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Set Content Security Policy -->
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; style-src 'self' https://cdnjs.cloudflare.com; frame-src 'self';">

    <!-- Set Referrer Policy -->
    <meta name="referrer" content="no-referrer">

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