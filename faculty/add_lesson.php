<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_POST['submit'])) {
    $id = date('dmYHis');

    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    $category_id = $_POST['category_id'];
    $category_id = filter_var($category_id, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = $id . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../tmp/' . $rename;

    $add_playlist = $conn->prepare("INSERT INTO `tbl_lessons` (`lesson_id`, `category_id`, `teacher_id`, `lesson_title`, `lesson_desc`, `thumb`, `date`, `status`) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
    $add_playlist->execute([$id, $category_id, $teacher_id, $title, $description, $rename, $status]);

    move_uploaded_file($image_tmp_name, $image_folder);

    $message[] = 'New playlist created!';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lessons</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/admin_header.php'; ?>

    <section class="playlist-form">

        <h1 class="heading">create lesson</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <p>lesson status <span>*</span></p>
            <select name="status" class="box" required>
                <option value="" selected disabled>-- select status</option>
                <option value="active">active</option>
                <option value="deactive">deactive</option>
            </select>
            <p>lesson title <span>*</span></p>
            <input type="text" name="title" maxlength="100" required placeholder="enter lesson title" class="box">
            <p>lesson description <span>*</span></p>
            <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30"
                rows="10"></textarea>
            <p>Category <span>*</span></p>
            <select name="category_id" class="box" required>
                <option value="" selected disabled>-- Select category</option>
                <?php
                $categories_query = $conn->query("SELECT * FROM tbl_categories");
                while ($category = $categories_query->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                }
                ?>
            </select>
            <p>lesson thumbnail <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
            <input type="submit" value="create playlist" name="submit" class="btn">
        </form>

    </section>

    <script src="../scripts/script.js"></script>

</body>

</html>