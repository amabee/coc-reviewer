<?php
session_start();
require('../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
}

$query = "SELECT * FROM tbl_audit ORDER BY timestamp DESC LIMIT 5";
$stmt = $conn->prepare($query);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get student count
$stmtStudentCount = $conn->prepare("SELECT COUNT(*) as student_count FROM tbl_students");
$stmtStudentCount->execute();
$studentCount = $stmtStudentCount->fetch(PDO::FETCH_ASSOC)['student_count'];

// Get teacher count
$stmtTeacherCount = $conn->prepare("SELECT COUNT(*) as teacher_count FROM tbl_teachers");
$stmtTeacherCount->execute();
$teacherCount = $stmtTeacherCount->fetch(PDO::FETCH_ASSOC)['teacher_count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>COC REVIEWER - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- sweet alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">



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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Students Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Enrolled Students</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $studentCount; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Teachers Card  -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Teachers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $teacherCount; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Passing Rate Card  -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Passing Rate</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">
                        <!-- Bar Chart -->
                        <div class="col-xl-12 col-lg-9">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Activity Overview</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="studentTable">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Table Name</th>
                                                    <th>Log Message</th>
                                                    <th>IP Address</th>
                                                    <th>Timestamp</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($students as $student) : ?>
                                                    <tr>
                                                        <td><?php echo $student['action']; ?></td>
                                                        <td><?php echo $student['table_name']; ?></td>
                                                        <td><?php echo $student['log_message']; ?></td>
                                                        <td><?php echo $student['ip_addr']; ?></td>
                                                        <td><?php echo $student['timestamp']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-bar-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

        <!-- Own Custom Scripts -->
        <script src="js/myjs.js"></script>

        <!-- Include DataTables JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

</body>

</html>