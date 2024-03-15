<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<header class="header">

    <section class="flex">
    <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
         
        </div>
        <a href="home.php" class="logo">PHINMA COC</a>

        <form action="search_lesson.php" method="post" class="search-form">
            <input type="text" name="search_lesson" placeholder="search lessons..." required maxlength="100">
            <button type="submit" class="fas fa-search" name="search_lesson_btn"></button>
        </form>

        <div class="icons">
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `tbl_students` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <img src="../tmp/<?= $fetch_profile['image']; ?>" alt="">
                <h3>
                    <?= $fetch_profile['firstname']; ?>
                    <?= $fetch_profile['lastname']; ?>
                </h3>
                <span>
                    <?= $fetch_profile['id']; ?>
                </span>
                <a href="profile.php" class="btn">view profile</a>
                <a href="../includes/user_logout.php" onclick="return confirm('logout from this website?');"
                    class="delete-btn">logout</a>
                <?php
            } else {
                ?>
                <h3>please login or register</h3>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
                <?php
            }
            ?>
        </div>

    </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

    <div class="close-side-bar">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `tbl_students` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="../tmp/<?= $fetch_profile['image']; ?>" alt="">
            <h3>
                <?= $fetch_profile['firstname']; ?>
                <?= $fetch_profile['lastname']; ?>
            </h3>
            <span>
                <?= $fetch_profile['id']; ?>
            </span>
            <a href="profile.php" class="btn">view profile</a>

            <nav class="navbar">
                <a href="home.php"><i class="fas fa-home"></i><span>HOME</span></a>
                <a href="lessons.php"><i class="fas fa-graduation-cap"></i><span>LESSONS</span></a>
                <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>TEACHERS</span></a>
            </nav>
            <?php
        } else {
            ?>
            <h3>Please Login or Register</h3>
            <style>
                .side-bar {
                    background: url('../assets/undraw_access_denied_re_awnf.svg') center center no-repeat;
                    background-size: 100% 100%;
                }
            </style>

            <?php
        }
        ?>
    </div>



</div>

<!-- side bar section ends -->