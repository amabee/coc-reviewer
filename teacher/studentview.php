<?php
session_start();
include '../includes/connection.php';

if (isset($_COOKIE['teacher_id'])) {
    $teacher_id = $_COOKIE['teacher_id'];
} else {
    $teacher_id = '';
    header('location:login.php');
}

if (isset($_GET['section_id'])) {
    $section_id = $_GET['section_id'];
} else {
    $section_id = '';
    header('location:myclass.php');
}


$select_students = $conn->prepare("SELECT tbl_studentclasses.student_id, tbl_students.firstname, tbl_students.lastname, tbl_students.email, tbl_students.image
                                 FROM tbl_studentclasses
                                 INNER JOIN tbl_students ON tbl_studentclasses.student_id = tbl_students.id
                                 WHERE tbl_studentclasses.section_name = ?
                                 ");
$select_students->execute([$section_id]);
$students = $select_students->fetchAll(PDO::FETCH_ASSOC);

// PAGINATION CODE...
$studentsPerPage = 10;
$totalStudents = count($students);
$totalPages = ceil($totalStudents / $studentsPerPage);
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $studentsPerPage;
$currentPageStudents = array_slice($students, $offset, $studentsPerPage);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">


</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <section class="student_view">

        <h1 class="heading">Student List</h1>

        <div class="box-container">

            <!-- inline style end -->
            <div class="box" style="overflow-x:auto;">
                <button class="btn" style="width:auto; float: right; margin-bottom: 20px">Add Student</button>
                <input type="text" class="search-student" placeholder="Search Student...">
                <table style="font-size: 16px;">
                    <thead>
                        <tr>
                            <th>Student ID</th>

                            <th>Student Firstname</th>
                            <th>Student Lastname</th>
                            <th>Student Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($currentPageStudents as $student): ?>
                            <tr>
                                <td>
                                    <?= $student['student_id'] ?>
                                </td>
                                <td>
                                    <?= $student['firstname'] ?>
                                </td>
                                <td>
                                    <?= $student['lastname'] ?>
                                </td>
                                <td>
                                    <?= $student['email'] ?>
                                </td>
                                <td>
                                    <a href="#" class="delete-btn" style="border-radius: 5rem;"><i
                                            class="fa-solid fa-user-slash"></i></a>
                                    <a href="#" class="btn" style="border-radius: 5rem;"><i
                                            class="fa-solid fa-chart-simple"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

                <div>
                    <div class="pagination-sv">
                        <?php if ($currentPage > 1): ?>
                            <a href="?section_id=<?= $section_id ?>&page=<?= $currentPage - 1 ?>"
                                class="pagination-button">&laquo; Previous</a>
                        <?php endif; ?>

                        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                            <a href="?section_id=<?= $section_id ?>&page=<?= $page ?>"
                                class="pagination-link<?= ($page == $currentPage) ? ' current-page' : '' ?>">
                                <?= $page ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?section_id=<?= $section_id ?>&page=<?= $currentPage + 1 ?>"
                                class="pagination-button">Next &raquo;</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <script src="../scripts/script.js"></script>


</body>

</html>