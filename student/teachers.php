<?php
session_start();
include '../includes/connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (empty($_SESSION['user_id'])) {
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
    <title>teachers</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../styles/style.css">

      <!-- sweet alert -->

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include '../includes/user_header.php'; ?>

    <!-- teachers section starts  -->

    <section class="teachers">

        <h1 class="heading">Teachers</h1>

        <form action="search_teacher.php" method="post" class="search-teacher">
            <input type="text" name="search_teacher" maxlength="100" placeholder="search teacher..." required>
            <button type="submit" name="search_teacher_btn" class="fas fa-search"></button>
        </form>

        <div class="box-container">

            <?php
            $select_tutors = $conn->prepare("
            SELECT tbl_section.teacher_id, tbl_teachers.firstname, tbl_teachers.lastname ,tbl_studentclasses.student_id, tbl_teachers.email, tbl_teachers.image
            FROM tbl_section
            INNER JOIN tbl_teachers ON tbl_section.teacher_id = tbl_teachers.teacher_id
            INNER JOIN tbl_studentclasses ON tbl_section.section_id = tbl_studentclasses.section_name
            WHERE student_id = :student_id;
        ");

            $select_tutors->bindParam(':student_id', $user_id);

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
                    $total_contents = $count_contents->rowCount();


                    $count_comments = $conn->prepare("SELECT * FROM `tbl_comments` WHERE teacher_id = ?");
                    $count_comments->execute([$tutor_id]);
                    $total_comments = $count_comments->rowCount();
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
                echo '<p class="empty">no teachers found!</p>';
            }
            ?>

        </div>

    </section>

    <!-- teachers section ends -->

    <!-- custom js file link  -->
    <script src="../scripts/script.js"></script>

</body>

</html>