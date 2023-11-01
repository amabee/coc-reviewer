<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_POST['delete_material'])) {
    $delete_id = $_POST['material_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $verify_material = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
    $verify_material->execute([$delete_id]);
    if ($verify_material->rowCount() > 0) {
        $delete_material_thumb = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
        $delete_material_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_material_thumb->fetch(PDO::FETCH_ASSOC);
        unlink('../tmp/' . $fetch_thumb['thumbnail']);
        $delete_material = $conn->prepare("SELECT * FROM `tbl_learningmaterials` WHERE material_id = ? LIMIT 1");
        $delete_material->execute([$delete_id]);
        $fetch_material = $delete_material->fetch(PDO::FETCH_ASSOC);
        unlink('../tmp/' . $fetch_material['file']);
        $delete_comments = $conn->prepare("DELETE FROM `tbl_comments` WHERE material_id = ?");
        $delete_comments->execute([$delete_id]);
        $delete_content = $conn->prepare("DELETE FROM `tbl_learningmaterials` WHERE material_id = ?");
        $delete_content->execute([$delete_id]);
        $message[] = 'material deleted!';
    } else {
        $message[] = 'material already deleted!';
    }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/admin_header.php'; ?>

    <section class="contents">

        <h1 class="heading">your materials</h1>

        <div class="box-container">

            <div class="box" style="text-align: center;">
                <h3 class="title" style="margin-bottom: .5rem;">create new material</h3>
                <a href="add_materials.php" class="btn">add content</a>
            </div>

            <?php
            $select_materials = $conn->prepare("SELECT lm.*, l.teacher_id 
            FROM tbl_learningmaterials lm
            INNER JOIN tbl_lessons l ON lm.lesson_id = l.lesson_id
            WHERE l.teacher_id = ? 
            ORDER BY lm.date_created DESC");
            $select_materials->execute([$teacher_id]);
            if ($select_materials->rowCount() > 0) {
                while ($fecth_materials = $select_materials->fetch(PDO::FETCH_ASSOC)) {
                    $material_id = $fecth_materials['material_id'];
                    ?>
                    <div class="box">
                        <div class="flex">
                            <div><i class="fas fa-dot-circle" style="<?php if ($fecth_materials['status'] == 'active') {
                                echo 'color:limegreen';
                            } else {
                                echo 'color:red';
                            } ?>"></i><span style="<?php if ($fecth_materials['status'] == 'active') {
                                 echo 'color:limegreen';
                             } else {
                                 echo 'color:red';
                             } ?>">
                                    <?= $fecth_materials['status']; ?>
                                </span></div>
                            <div><i class="fas fa-calendar"></i><span>
                                    <?= $fecth_materials['date_created']; ?>
                                </span></div>
                        </div>
                        <img src="../tmp/<?= $fecth_materials['thumbnail']; ?>" class="thumb" alt="">
                        <h3 class="title">
                            <?= $fecth_materials['material_title']; ?>
                        </h3>
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="material_id" value="<?= $material_id; ?>">
                            <a href="update_content.php?get_id=<?= $material_id; ?>" class="option-btn">update</a>
                            <input type="submit" value="delete" class="delete-btn"
                                onclick="return confirm('delete this material?');" name="delete_material">
                        </form>
                        <a href="view_material.php?get_id=<?= $material_id; ?>" class="btn">view content</a>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no contents added yet!</p>';
            }
            ?>

        </div>

    </section>


    <script src="../scripts/script.js"></script>

</body>

</html>