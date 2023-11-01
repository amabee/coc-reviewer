<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (empty($_SESSION['user_id']) || (empty($_COOKIE['user_id']))) {
    header("Location: ../unauthorized.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <section class="teachers">

        <h1 class="heading">expert teachers</h1>

        <form action="" method="post" class="search-teacher">
            <input type="text" name="search_tutor" maxlength="100" placeholder="search tutor..." required>
            <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
        </form>

        <div class="box-container">

            <?php
            if (isset($_POST['search_tutor']) || isset($_POST['search_tutor_btn'])) {
                $search_tutor = '%' . $_POST['search_tutor'] . '%';
                $select_tutors = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE firstname LIKE :search_term OR lastname LIKE :search_term");
                $select_tutors->bindParam(':search_term', $search_tutor, PDO::PARAM_STR);
                $select_tutors->execute();
                if ($select_tutors->rowCount() > 0) {
                    while ($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)) {

                        $tutor_id = $fetch_tutor['teacher_id'];

                        $count_playlists = $conn->prepare("SELECT * FROM `tbl_lessons` WHERE teacher_id = ?");
                        $count_playlists->execute([$tutor_id]);
                        $total_playlists = $count_playlists->rowCount();

                        $count_contents = $conn->prepare("SELECT LM.* FROM `tbl_learningmaterials` LM
                        JOIN `tbl_lessons` L ON LM.lesson_id = L.lesson_id
                        WHERE L.teacher_id = ?");
                        $count_contents->execute([$tutor_id]);
                        $total_contents = $count_contents->rowCount()
                        ?>
                        <div class="box">
                            <div class="tutor">
                                <img src="../tmp/<?= $fetch_tutor['image']; ?>" alt="">
                                <div>
                                    <h3>
                                        <?= $fetch_tutor['firstname']; ?>
                                        <?= $fetch_tutor['lastname']; ?>
                                    </h3>

                                </div>
                            </div>
                            <p>Lessons : <span>
                                    <?= $total_playlists; ?>
                                </span></p>
                            <p>Number of Materials Posted : <span>
                                    <?= $total_contents ?>
                                </span></p>
                            <form action="teacher_profile.php" method="post">
                                <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
                                <input type="submit" value="view profile" name="tutor_fetch" class="inline-btn">
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="empty">no results found!</p>';
                }
            } else {
                echo '<p class="empty">please search something!</p>';
            }
            ?>

        </div>

    </section>

    <!-- teachers section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>