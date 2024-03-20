<?php
session_start();
include('../includes/connection.php');

// reCAPTCHA site key and secret key
$recaptcha_site_key = "6LfNJ54pAAAAANHeD0Y2X-mEdH9Q1vRR4KruAZAq";
$recaptcha_secret_key = "6LfNJ54pAAAAAEV1VLve6BtG1PnlJBAeh8wULGni";

try {
    $message = "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verify reCAPTCHA response
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_data = array(
            'secret' => $recaptcha_secret_key,
            'response' => $recaptcha_response
        );
        $recaptcha_options = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($recaptcha_data)
            )
        );
        $recaptcha_context = stream_context_create($recaptcha_options);
        $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
        $recaptcha_json = json_decode($recaptcha_result);

        if ($recaptcha_json->success) {
            // reCAPTCHA verification successful
            $password = $_POST["password"];
            $email = htmlspecialchars($email);
            $hashedPassword = sha1($password);

            // Your existing login logic
            // Track login attempts
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 1;
            } else {
                $_SESSION['login_attempts']++;
            }

            $stmt = $conn->prepare("SELECT `admin_id`, `email` FROM `tbl_admin` WHERE `email`=:email AND `password`=:password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['loggedin'] = true;
                $_SESSION['admin_id'] = $row['admin_id'];
                $_SESSION['login_attempts'] = 0; // Reset login attempts on successful login
                header("Location: index.php");
                exit();
            } else {
                $message = "Invalid Username or Password!!";
                if ($_SESSION['login_attempts'] >= 3) {
                    $_SESSION['login_locked'] = time() + 120; // Lock login for 10 seconds
                }
            }

            $stmt->closeCursor();
        } else {
            // reCAPTCHA verification failed
            $message = "reCAPTCHA verification failed!";
        }
    }
} catch (PDOException $ex) {
    error_log("Login failed: " . $ex->getMessage(), 0);
    die("Oops! Something went wrong during login. Please try again later.");
}

// Redirect if already logged in
if (isset($_SESSION['admin_id']) && isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit();
}

// Check if login is locked
if (isset($_SESSION['login_locked']) && $_SESSION['login_locked'] > time()) {
    $time_left = $_SESSION['login_locked'] - time();
    // $message = "Login is temporarily locked. Please try again in " . $time_left . " seconds.";
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
    <title>COC-REVIEWER ADMIN</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Add the reCAPTCHA script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        $(document).ready(function() {
            <?php if (isset($_SESSION['login_locked']) && $_SESSION['login_locked'] > time()) : ?>
                var time_left = <?php echo $_SESSION['login_locked'] - time(); ?>;
                $('button[type="submit"]').prop('disabled', true);
                $('button[type="submit"]').css('cursor', 'not-allowed'); // Add cursor style
                $('button[type="submit"]').text('Try again in ' + time_left + ' seconds');
                var countdown_interval = setInterval(function() {
                    if (time_left <= 0) {
                        clearInterval(countdown_interval);
                        $('button[type="submit"]').prop('disabled', false);
                        $('button[type="submit"]').css('cursor', 'pointer'); // Restore cursor style
                        $('button[type="submit"]').text('Login');
                    } else {
                        $('button[type="submit"]').text('Try again in ' + time_left + ' seconds');
                        time_left--;
                    }
                }, 1000);
            <?php endif; ?>
        });
    </script>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, #F3E0E0, #E4F2CB, #C7ECDD);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 h-100">
                                <div class="p-5 ">
                                    <div class="text-center">
                                        <h1 class="h1 text-gray-900 mb-4"> <b>ADMIN LOGIN</b> </h1>
                                    </div>
                                    <form class="user mt-5" action="login.php" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required value="<?php echo $email; ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" id="exampleInputPassword" placeholder="Password" required>
                                        </div>

                                        <!-- Add the reCAPTCHA widget -->
                                        <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" <?php if (isset($_SESSION['login_locked']) && $_SESSION['login_locked'] > time()) echo 'disabled'; ?>>
                                            Login
                                        </button>
                                        <span id="error-message" class="text-center" style="display: block; color: red;">
                                            <br><?php echo $message; ?>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <center>
                                    <img style="height: 420px;" src="https://scontent.fcgy2-2.fna.fbcdn.net/v/t39.30808-6/353832082_590289946586763_3338392738682972305_n.jpg?_nc_cat=1&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeEw87IyDVvsp_wvd-8TDhYw4sTCzPSrp3jixMLM9KuneDQH4QvqHuXjlytLkiWPGmR1T2t4NqfcV21CzOTQTf5c&_nc_ohc=o587yaeXTL8AX9dnlNO&_nc_ht=scontent.fcgy2-2.fna&oh=00_AfBgGtx-Ew9svkG8F8qQXBrX657GIMIPe8Rece9PBPz50g&oe=65FE5C95" alt="">
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    // Add event listeners to clear the error message when username or password inputs are clicked
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("exampleInputEmail").addEventListener("click", clearErrorMessage);
        document.getElementById("exampleInputPassword").addEventListener("click", clearErrorMessage);
    });

    function clearErrorMessage() {
        document.getElementById("error-message").style.display = "none"; // Hide the error message
    }

    // Display the error message again if the login attempt fails
    <?php if (!empty($message)) : ?>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("error-message").style.display = "block"; // Show the error message
        });
    <?php endif; ?>
</script>