<?php
session_start();
require('../includes/connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>COC REVIEWER - Admin Profile</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- sweet alert  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" data-admin-id="<?php echo $_SESSION['admin_id']; ?>">
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

                <div class="container-fluid rounded bg-white mt-5 mb-5">
                    <!-- Page Heading -->
                    <h1 class="h3 text-gray-800 mt-5 d-flex justify-content-between">
                        Admin Profile
                    </h1>


                    <hr>

                    <div class="row">
                        <div class="col-md-5 border-right">
                            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                                <span class="font-weight-bold" id="displayName">User</span>
                                <span class="text-black-50" id="displayEmail">User Mail</span>

                                <span> </span>
                            </div>
                        </div>
                        <div class="col-md-5 border-right">
                            <div class="p-3 py-2">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Profile Settings</h4>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="labels" for="firstname">Firstname</label>
                                        <input type="text" class="form-control" id="firstname" placeholder="first name" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels" for="lastname">Lastname</label>
                                        <input type="text" class="form-control" id="lastname" placeholder="surname" value="">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="labels" for="Admin_id">Admin ID</label>
                                        <input type="text" class="form-control" id="admin_id" placeholder="enter admin ID" value="">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="labels" for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="enter email" value="">
                                    </div>
                                </div>

                                <div class="mt-5 text-center">
                                    <button class="btn btn-primary profile-button" type="button" onclick="updateProfile()">Update Profile</button>
                                </div>
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

    <script src="js/adminProfile.js"></script>

</body>

</html>