<?php

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

        <a href="dashboard.php" class="logo">Faculty</a>

        <form action="search_page.php" method="post" class="search-form">
            <input type="text" name="search" placeholder="search here..." required maxlength="100">
            <button type="submit" class="fas fa-search" name="search_btn"></button>
        </form>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE teacher_id = ?");
            $select_profile->execute([$teacher_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <img src="../tmp/<?= $fetch_profile['image']; ?>" alt="">
                <h3>
                    <?= $fetch_profile['firstname']; ?>
                    <?= $fetch_profile['lastname']; ?>
                </h3>
                <span>
                    <!-- <?= $fetch_profile['profession']; ?> -->
                    TEACHER
                </span>
                <a href="profile.php" class="btn">view profile</a>
                <a href="../includes/teacher_logout.php" onclick="return confirm('logout from this website?');"
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
        $select_profile = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE teacher_id = ?");
        $select_profile->execute([$teacher_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="../tmp/<?= $fetch_profile['image']; ?>" alt="">
            <h3>
                <?= $fetch_profile['firstname']; ?>
                <?= $fetch_profile['lastname']; ?>
            </h3>
            <span>
                <?= $fetch_profile['teacher_id']; ?>
            </span>
            <a href="profile.php" class="btn">view profile</a>
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

    <nav class="navbar">
        <a href="dashboard.php"><i class="fas fa-home"></i><span>HOME</span></a>
        <a href="lessons.php"><i class="fa-solid fa-bars-staggered"></i><span>LESSONS</span></a>
        <a href="materials.php"><i class="fas fa-graduation-cap"></i><span>MATERIALS</span></a>
        <a href="quizzes.php"><i class="fas fa-pen-fancy"></i><span>QUIZZES</span></a>
        <!-- <a href="../components/teacher_logout.php" onclick="return confirm('logout from this website?');"><i
                class="fas fa-right-from-bracket"></i><span>LOGOUT</span></a> -->
    </nav>

</div>

<!-- side bar section ends -->