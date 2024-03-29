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

    <title>COC REVIEWER - Dean Profile</title>

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

                <div class="container-fluid rounded bg-white mt-5 mb-5">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-0 text-gray-800 mt-2 d-flex justify-content-between align-items-center">
                        Dean Information
                        <button type="button" class="btn btn-primary ml-auto mt-3" data-toggle="modal" data-target="#addDeanModal">Create New Dean Account</button>
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
                                    <h4 class="text-right">Select Dean</h4>
                                </div>
                                <div class="row mt-2">
                                    <select name="selectDean" id="selectDean" class="form-control">
                                        <option value="" selected disabled>-- SELECT DEAN --</option>
                                        <?php
                                        $query = "SELECT dean_id, firstname, lastname FROM tbl_dean";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $deans = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach ($deans as $dean) {
                                            echo "<option value='{$dean['dean_id']}'>{$dean['firstname']} {$dean['lastname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="p-3 py-2">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="text-right">Profile Settings</h4>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="labels" for="firstname">Firstname</label>
                                        <input type="text" class="form-control" id="firstname" placeholder="first name" value="" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labels" for="lastname">Lastname</label>
                                        <input type="text" class="form-control" id="lastname" placeholder="surname" value="" disabled>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="labels" for="dean_id">Dean ID</label>
                                        <input type="text" class="form-control" id="dean_id" placeholder="enter dean ID" value="" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="labels" for="email">Email</label>
                                        <input type="text" class="form-control" id="email" placeholder="enter email" value="" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="labels" for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="enter password" value="" disabled>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="labels" for="activeStatus">Active Status</label>
                                        <select id="activeStatus" class="form-control" disabled>
                                            <option value="" selected disabled>-- SELECT STATUS --</option>
                                            <option value="active">active</option>
                                            <option value="inactive">inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-5 text-center">
                                    <button class="btn btn-primary profile-button" id="updateDeanProfileBtn" type="button" disabled>Update Profile</button>
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

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- myjs script -->
    <script src="js/myjs.js"></script>
    <!-- own script -->
    <script>
        document.getElementById('selectDean').addEventListener('change', function() {

            var btn = document.getElementById("updateDeanProfileBtn");
            var fname = document.getElementById("firstname");
            var lname = document.getElementById("lastname");
            var dean_id = document.getElementById("dean_id");
            var email = document.getElementById("email");
            var pass = document.getElementById("password");
            var activeStatus = document.getElementById("activeStatus");
            if (this.value == "") {
                btn.disabled = true;
                fname.disabled = true;
                lname.disabled = true;
                dean_id.disabled = true;
                email.disabled = true;
                pass.disabled = true;
                activeStatus.disabled = true;
            } else {
                btn.disabled = false;
                fname.disabled = false;
                lname.disabled = false;
                dean_id.disabled = false;
                email.disabled = false;
                pass.disabled = false;
                activeStatus.disabled = false;
            }

            var selectedDeanId = this.value;

            function setValueById(id, value) {
                var element = document.getElementById(id);
                if (element) {
                    if (element.tagName === 'SPAN') {
                        element.innerText = value || '';
                    } else {
                        element.value = value || '';
                    }
                }
            }

            if (selectedDeanId) {
                fetch('queries/getDeanInfo.php?dean_id=' + selectedDeanId)
                    .then(response => response.json())
                    .then(deanInfo => {
                        setValueById('firstname', deanInfo.firstname);
                        setValueById('lastname', deanInfo.lastname);
                        setValueById('dean_id', deanInfo.dean_id);
                        setValueById('email', deanInfo.email);
                        setValueById('activeStatus', deanInfo.isActive);

                        setValueById('displayName', deanInfo.firstname + " " + deanInfo.lastname);
                        setValueById('displayEmail', deanInfo.email);
                    })
                    .catch(error => {
                        console.error('Error fetching dean information', error);
                    });
            } else {
                setValueById('firstname');
                setValueById('lastname');
                setValueById('dean_id');
                setValueById('email');
                setValueById('activeStatus');
                setValueById('displayName');
                setValueById('displayEmail');
            }
        });
    </script>

</body>

</html>