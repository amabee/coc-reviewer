<?php
session_start();
require('../includes/connection.php');

if (!isset($_SESSION['admin_id']) && $_SESSION['loggedin'] != true) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- THE BOXICONS LINK -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <!-- MY STYLE -->
    <link rel="stylesheet" href="styles/style.css">
    <title>COC REVIEWER - ADMIN</title>
</head>

<body>

    <?php
    include('includes/sidebar.php');
    ?>

    <!-- CONTENT -->
    <section id="content">
        <?php include('includes/navbar.php'); ?>
        <div id="dynamic-content">
        </div>
    </section>
    <!-- CONTENT END -->


</body>
<!-- JQEURY -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- THE JS FOR DYNAMIC ROUTING -->
<script src="js/router.js"></script>

<!-- THE JS FOR NAVBAR RESIZING -->
<script src="js/navbar_resize.js"></script>

<!-- THE OWN JS -->
<script src="js/script.js"></script>


</html>