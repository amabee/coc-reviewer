<?php
session_start();
include '../includes/connection.php';

if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}


// if (isset($_POST['delete_material'])) {
//     $delete_id = $_POST['material_id'];
//     $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
//     $verify_material = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
//     $verify_material->execute([$delete_id]);
//     if ($verify_material->rowCount() > 0) {
//         $delete_material_thumb = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
//         $delete_material_thumb->execute([$delete_id]);
//         $fetch_thumb = $delete_material_thumb->fetch(PDO::FETCH_ASSOC);
//         unlink('../tmp/' . $fetch_thumb['thumbnail']);
//         $delete_material = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
//         $delete_material->execute([$delete_id]);
//         $fetch_material = $delete_material->fetch(PDO::FETCH_ASSOC);
//         unlink('../tmp/' . $fetch_material['file']);
//         $delete_comments = $conn->prepare("DELETE FROM `tbl_comments` WHERE material_id = ?");
//         $delete_comments->execute([$delete_id]);
//         $delete_content = $conn->prepare("DELETE FROM `tbl_learningmaterials` WHERE material_id = ?");
//         $delete_content->execute([$delete_id]);
//         $message[] = 'material deleted!';
//     } else {
//         $message[] = 'material already deleted!';
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <section class="contents">

        <h1 class="heading">your materials</h1>

        <div class="box-container">

            <div class="box" style="text-align: center;">
                <h3 class="title" style="margin-bottom: .5rem;">create new quiz</h3>
                <a href="add_quiz.php" class="btn">add quiz</a>
            </div>

            <?php
            $itemsPerPageMaterials = 3;
            $pageMaterials = isset($_GET['pageMaterials']) ? $_GET['pageMaterials'] : 1;
            $offsetMaterials = ($pageMaterials - 1) * $itemsPerPageMaterials;

            $countQuery = $conn->prepare("SELECT COUNT(*) FROM tbl_quiz q
                            INNER JOIN tbl_lessons l ON q.lesson_id = l.lesson_id
                            WHERE l.teacher_id = ?");
            $countQuery->execute([$teacher_id]);
            $totalQuizMaterials = $countQuery->fetchColumn();

            $select_quiz = $conn->prepare("SELECT q.*, l.teacher_id 
            FROM tbl_quiz q
            INNER JOIN tbl_lessons l ON q.lesson_id = l.lesson_id
            WHERE l.teacher_id = ? 
            ORDER BY q.quiz_created DESC
            LIMIT $offsetMaterials, $itemsPerPageMaterials");
            $select_quiz->execute([$teacher_id]);

            if ($select_quiz->rowCount() > 0) {
                while ($fetch_quizzes = $select_quiz->fetch(PDO::FETCH_ASSOC)) {
                    $material_id = $fetch_quizzes['quiz_id'];
                    ?>
                    <div class="box">
                        <div class="flex">
                            <div>
                                <i class="fas fa-dot-circle" style="<?php
                                if ($fetch_quizzes['status'] == 'active') {
                                    echo 'color:limegreen';
                                } else {
                                    echo 'color:red';
                                } ?>"></i>
                                <span style="<?php
                                if ($fetch_quizzes['status'] == 'active') {
                                    echo 'color:limegreen';
                                } else {
                                    echo 'color:red';
                                } ?>">
                                    <?= $fetch_quizzes['status']; ?>
                                </span>
                            </div>
                            <div>
                                <i class="fas fa-calendar"></i>
                                <span>
                                    <?= $fetch_quizzes['quiz_created']; ?>
                                </span>
                            </div>
                        </div>
                     
                        <h3 class="title">
                            <?= $fetch_quizzes['quiz_title']; ?>
                        </h3>
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="material_id" value="<?= $material_id; ?>">
                            <input type="submit" value="delete" class="delete-btn"
                                onclick="return confirm('remove this quiz?');" name="delete_material">
                        </form>
                        <a href="manage_quiz.php?quiz_id=<?= $material_id; ?>" class="btn">manage quiz</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no quizzes made yet!</p>';
            }
            ?>


        </div>

    </section>

    <?php
    $totalQuizzes = ceil($totalQuizMaterials / $itemsPerPageMaterials);
    echo '<div class="pagination">';
    if ($pageMaterials > 1) {
        echo '<a href="?pageMaterials=' . ($pageMaterials - 1) . '">Previous</a>';
    }
    for ($i = 1; $i <= $totalQuizzes && $totalQuizzes > 5; $i++) {
        echo '<a href="?pageMaterials=' . $i . '" class="' . ($pageMaterials == $i ? 'active' : '') . '">' . $i . '</a>';
    }
    if ($pageMaterials < $totalQuizzes) {
        echo '<a href="?pageMaterials=' . ($pageMaterials + 1) . '">Next</a>';
    }
    echo '</div>';
    ?>



    <script src="../scripts/script.js"></script>

</body>

</html>