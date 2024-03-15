<?php
session_start();
include('../includes/connection.php');

try {
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $email = htmlspecialchars($email);

        $hashedPassword = sha1($password);

        $stmt = $conn->prepare("SELECT `dean_id`, `email` FROM `tbl_dean` WHERE `email`=:email AND `password`=:password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['loggedin'] = true;
            $_SESSION['dean_id'] = $row['dean_id'];
            header("Location: index.php");
            exit();
        } else {
            $message = "Invalid Credentials";
        }

        $stmt->closeCursor();
    }
} catch (PDOException $ex) {
    error_log("Login failed: " . $ex->getMessage(), 0);
    die("Oops! Something went wrong during login. Please try again later.");
}

if (isset($_SESSION['dean_id']) && isset($_SESSION['loggedin'])) {
    header('Location: index.php');
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

    <title>COC-REVIEWER DEAN</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<body style="font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #D5F9D1, #CCEEE0, #C6D4F3);"
>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                            <div class="col-lg-6 h-100">
                                <div class="p-5 ">
                                    <div class="text-center">
                                        <h1 class="h1 text-gray-900 mb-4"> <b>DEAN LOGIN</b> </h1>
                                    </div>
                                    <form class="user" action="login.php" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" id="exampleInputPassword" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block mt-5">
                                            Login
                                        </button>


                                    </form>
                                    <hr>
                                    <span class="text-center" style="display: block; color: red;">
                                        <?php echo $message; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div style="height: 410px;">
                                <img src="https://scontent.fcgy2-1.fna.fbcdn.net/v/t39.30808-6/353832082_590289946586763_3338392738682972305_n.jpg?_nc_cat=1&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeEw87IyDVvsp_wvd-8TDhYw4sTCzPSrp3jixMLM9KuneDQH4QvqHuXjlytLkiWPGmR1T2t4NqfcV21CzOTQTf5c&_nc_ohc=v4mCj6xNntEAX8D5gM2&_nc_ht=scontent.fcgy2-1.fna&oh=00_AfDuy-QlmMDLjRW-AQ7IeN4GcpvLOj-eB4O890jxLyVa3Q&oe=65F86DD5" alt="COC SHIT" style="max-height: 100%; max-width: 100%;">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>