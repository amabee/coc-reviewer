<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Class</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <section class="playlists">

        <h1 class="heading">Assigned Sections</h1>

        <div class="box-container">

            <?php
            $itemsPerPage = 3;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $itemsPerPage;

            $countQuery = $conn->prepare("SELECT COUNT(*) FROM `tbl_section` WHERE teacher_id = ?");
            $countQuery->execute([$teacher_id]);
            $totalItems = $countQuery->fetchColumn();

            $select_playlist = $conn->prepare("SELECT * FROM `tbl_section` WHERE teacher_id = ? LIMIT $offset, $itemsPerPage");
            $select_playlist->execute([$teacher_id]);

            if ($select_playlist->rowCount() > 0) {
                while ($fetch_class = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                    $section_id = $fetch_class['section_id'];
                    $count_videos = $conn->prepare("SELECT * FROM `tbl_studentclasses` WHERE section_name = ?");
                    $count_videos->execute([$section_id]);
                    $total_student = $count_videos->rowCount();

                    // Create an image with the total_materials text
                    $text = $section_id;
                    $imageWidth = 100; // Adjust the width of the thumbnail
                    $imageHeight = 75; // Adjust the height of the thumbnail
                    $image = imagecreatetruecolor($imageWidth, $imageHeight);
                    $backgroundColor = imagecolorallocate($image, 0, 0, 0);
                    imagefill($image, 0, 0, $backgroundColor);
                    $textColor = imagecolorallocate($image, 255, 255, 255);
                    $font = '../assets/Roboto/Roboto-Bold.ttf';
                    $fontSize = 12;

                    // Calculate the position to center the text horizontally and vertically
                    $textWidth = imagefontwidth($fontSize) * strlen($text);
                    $textHeight = imagefontheight($fontSize);
                    $x = ($imageWidth - $textWidth) / 2.5;
                    $y = ($imageHeight - $textHeight) / 1.5;

                    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
                    $thumbnailPath = "../tmp/$section_id.png";
                    imagepng($image, $thumbnailPath);
                    imagedestroy($image);

                    ?>
                    <div class="box">
                        <div class="thumb">
                            <span>
                            <i class="fa-solid fa-users"></i>
                                <?= $total_student; ?>
                            </span>
                            <img src="<?= $thumbnailPath; ?>" alt="">
                        </div>
                        <h3 class="title">
                            <?= $fetch_class['section_id']; ?>
                        </h3>
                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="lesson_id" value="<?= $section_id; ?>">
                            <a href="studentview.php?section_id=<?= $section_id; ?>" class="option-btn">View students</a>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no assigned classes yet!</p>';
            }
            ?>

        </div>

    </section>

    <?php
    // Display pagination links
    $totalPages = ceil($totalItems / $itemsPerPage);

    echo '<div class="pagination">';
    if ($page > 1) {
        echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="?page=' . $i . '" class="' . ($page == $i ? 'active' : '') . '">' . $i . '</a>';
    }
    if ($page < $totalPages) {
        echo '<a href="?page=' . ($page + 1) . '">Next</a>';
    }
    echo '</div>';
    ?>


    <script src="../scripts/script.js"></script>

    <script>
        document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
            if (content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
        });
    </script>

</body>

</html>