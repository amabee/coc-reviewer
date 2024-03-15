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

$get_students = $conn->prepare("SELECT * FROM tbl_students");
$get_students->execute();
$allstudents = $get_students->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['remove_student'])) {
    try {
        $remove_student = $_POST['remove_student'];
        $remove_student = filter_var($remove_student, FILTER_SANITIZE_STRING);
        $student_removal = $conn->prepare("DELETE FROM `tbl_studentclasses` WHERE student_id = ?");
        $student_removal->execute([$remove_student]);
        header('location:myclass.php');
        echo "<script>alert('Success!')</script>";
    } catch (PDOException $ex) {
        echo "<script>alert($ex)</script>";
    }
}


// PAGINATION CODE...
$studentsPerPage = 10;
$totalStudents = count($students);
$totalPages = ceil($totalStudents / $studentsPerPage);
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($currentPage - 1) * $studentsPerPage;
$currentPageStudents = array_slice($students, $offset, $studentsPerPage);

?>

<!DOCTYPE html>
<html lang="en" class='light'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Include jQuery before DataTables -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="styles/datatable_responsive.css">
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>


    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">


</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <section class="student_view">

        <h1 class="heading">Student List</h1>

        <div class="box-container">

            <div class="box">

                <button class="btn" style="width:auto; float: right; margin-bottom: 20px" onclick="openModal()">Add Student</button>
                <table id="myTable" class="display" style="font-size: 16px;">
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
                        <?php foreach ($currentPageStudents as $student) : ?>
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
                                    <form method="post" onsubmit="return confirm('Remove this student?');">
                                        <input type="hidden" name="remove_student" value="<?= $student['student_id'] ?>">
                                        <button type="submit" class="delete-btn" style="border-radius: 5rem;">
                                            <i class="fa-solid fa-user-slash"></i>
                                        </button>
                                    </form>
                                    <a href="#" class="btn" style="border-radius: 5rem;">
                                        <i class="fa-solid fa-chart-simple"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- MODAL AREA -->
                <style>
                    .modal {
                        display: none;
                        position: fixed;
                        z-index: 1000;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        overflow: auto;
                        background-color: rgba(0, 0, 0, 0.7);
                    }

                    .modal-content {
                        margin: 0 auto;
                        width: 100%;
                        max-width: 500px;
                        box-sizing: border-box;
                    }

                    .close {
                        color: #aaa;
                        float: right;
                        font-size: 28px;
                        font-weight: bold;
                    }

                    .close:hover,
                    .close:focus {
                        color: black;
                        text-decoration: none;
                        cursor: pointer;
                    }

                    .side-bar,
                    .navbar {
                        z-index: 999;
                    }
                </style>

                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="box" style="width: 600px;">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <div id="boxbox" style="text-align: center;">
                                <h3 class="title" style="margin-bottom: .5rem; font-size: 25px;">Students List</h3>
                                <table id="studentTable" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($allstudents as $student) : ?>
                                            <tr>
                                                <td><?= $student['id'] ?></td>
                                                <td><?= $student['firstname'] ?></td>
                                                <td><?= $student['lastname'] ?></td>
                                                <td><?= $student['email'] ?></td>
                                                <td>
                                                    <button class="btn add-student-btn" style="height: 50px; width: 100px; font-size: 12px;" data-student-id="<?= $student['id'] ?>" onclick="addStudentNow(this.getAttribute('data-student-id'))">

                                                        Add Student
                                                    </button>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>



    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });

        $(document).ready(function() {
            $('#studentTable').DataTable({
                responsive: true
            });

            $('#studentTable tbody tr').each(function() {
                var studentId = $(this).find('td:first').text();
                checkStudentPresence(studentId);
            });



        });

        function addStudentNow(studentId) {
            addStudentToClass(studentId);
        }

        function checkStudentPresence(studentId) {
            $.ajax({
                url: 'check_student_presence.php',
                type: 'POST',
                data: {
                    student_id: studentId,
                    section_id: '<?= $section_id ?>'
                },
                success: function(response) {
                    if (response === 'true') {
                        $('.add-student-btn[data-student-id="' + studentId + '"]').text('Already in Class');
                    }
                },
                error: function(response) {
                    alert(response);
                }
            });
        }


        function addStudentToClass(studentId) {
            $.ajax({
                url: 'add_student_to_class.php',
                type: 'POST',
                data: {
                    student_id: studentId,
                    section_id: '<?= $section_id ?>'
                },
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        }

        function openModal() {
            var modal = document.getElementById('myModal');
            var modalContent = document.querySelector('.modal-content');
            modal.style.display = 'block';
            modalContent.style.marginTop = '10%';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }
    </script>
    <script src="../scripts/script.js"></script>



</body>

</html>