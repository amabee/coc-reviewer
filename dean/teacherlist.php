<?php

session_start();
require('../includes/connection.php');

if (!isset($_SESSION['dean_id'])) {
    header('Location: login.php');
}

$query = "SELECT * FROM tbl_teachers";
$stmt = $conn->prepare($query);
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>COC REVIEWER - Teacher List</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- sweet alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php
        include('includes/sidebar.php');
        ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include('includes/topbar.php');
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Teacher List</h1>
                    </div>



                    <div class="row">

                        <!-- STUDENT LIST DATATABLE -->
                        <div class="col-xl-10 col-lg-8 mx-auto">
                            <div class="card shadow mb-4">
                                <!-- Card Body -->
                                <div class="card-body ">
                                    <div class="table-responsive ">
                                        <table class="table table-bordered" id="studentTable">
                                            <thead>
                                                <tr>
                                                    <th>Teacher ID</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Gender</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($teachers as $teacher) : ?>
                                                    <tr>
                                                        <td><?php echo $teacher['teacher_id']; ?></td>
                                                        <td><?php echo $teacher['firstname']; ?></td>
                                                        <td><?php echo $teacher['lastname']; ?></td>
                                                        <td><?php echo $teacher['gender']; ?></td>
                                                        <td><?php echo $teacher['email']; ?></td>
                                                        <td>
                                                            <!-- <button class="btn btn-primary">Update</button> -->
                                                            <center> <button class="btn btn-success" data-toggle="modal" data-target="#teacherProfileModal" onclick="loadTeacherData('<?php echo htmlspecialchars($teacher['teacher_id'], ENT_QUOTES, 'UTF-8') ?>')">View Details</button>
                                                            </center>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php

    include('includes/modals.php');

    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Own Custom Scripts -->
    <script src="js/myjs.js"></script>

    <!-- Include DataTables JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#studentTable').DataTable();
        });
    </script>

</body>

</html>