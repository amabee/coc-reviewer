<?php
session_start();
include 'includes/connection.php';

// reCAPTCHA site key
$recaptcha_site_key = "6LfNJ54pAAAAANHeD0Y2X-mEdH9Q1vRR4KruAZAq";

if (isset($_POST['submit'])) {
    if (!isset($_POST['g-recaptcha-response'])) {
        // Handle the case where reCAPTCHA response is not set
        $error_message = 'reCAPTCHA verification failed!';
    } else {
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LfNJ54pAAAAAEV1VLve6BtG1PnlJBAeh8wULGni';
        $recaptcha_data = array(
            'secret' => $recaptcha_secret,
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
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $password = $_POST['pass'];
            $hashed_password = sha1($password);

            $select_user = $conn->prepare("SELECT id, password FROM `tbl_students` WHERE email = ? AND isActive = 'active' LIMIT 1");
            $select_user->execute([$email]);

            if ($select_user->rowCount() > 0) {
                $row = $select_user->fetch(PDO::FETCH_ASSOC);
                if ($hashed_password === $row['password']) {
                    // Successful login
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['student'];
                    $_SESSION['student_password'] = $hashed_password;
                    header('Location: student/home.php');
                    exit;
                } else {
                    // Incorrect password
                    $error_message = 'Incorrect email or password!';

                    echo '<script type="text/javascript">$("#invalidCredentialsModal").modal("show");</script>';
                }
            } else {
                // User not found
                $error_message = 'User not found!';
                // Trigger the display of the invalidCredentialsModal
                echo '<script type="text/javascript">$("#invalidCredentialsModal").modal("show");</script>';
            }
        } else {
            // reCAPTCHA verification failed
            $error_message = 'reCAPTCHA verification failed!';
            echo "<script>alert($error_message)</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles/index_style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-2 d-none d-md-flex"></div>
            <div class="col-md-4 d-none d-md-flex bg-image"></div>
            <div class="col-md-4 bg-light  bg-right">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-4">Welcome Back!</h3>
                                <p class="text-muted mb-4">Enter your credentials to continue.</p>
                                <form method="POST">
                                    <div class="form-group mb-3">
                                        <input id="inputEmail" type="email" placeholder="Email address" name="email" required autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputPassword" type="password" placeholder="Password" name="pass" required class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    </div>
                                    <!-- Move reCAPTCHA widget outside of the form-group div -->
                                    <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_site_key; ?>"></div>
                                    <div class="custom-control custom-checkbox mb-
                                    3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <input id="customCheck1" type="checkbox" checked class="custom-control-input">
                                            <label for="customCheck1" class="custom-control-label">Remember
                                                password</label>
                                        </div>
                                        <div>
                                            <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#accountProblem">No account yet?</a>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-success btn-block text-uppercase mb-2 rounded-pill shadow-sm">Sign
                                        in</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 d-none d-md-flex"></div>
        </div>
    </div>
    <!-- Modal for invalid credentials -->
    <div id="invalidCredentialsModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <img src="assets/undraw_warning_re_eoyh.svg" class="img-thumbnail" style="background-color: transparent; border:0;" alt="">
                </div>
                <div class="modal-body text-center">
                    <h4>Invalid Credentials</h4>
                    <p>
                        <?php echo $error_message; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for account problem -->
    <div id="accountProblem" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <img src="assets/undraw_contact_us_re_4qqt.svg" class="img-thumbnail" style="background-color: transparent; border:0;" alt="">
                </div>
                <div class="modal-body text-center">
                    <h4>Please contact the Admin or Faculty!</h4>
                    <p>Account creation is handled by the faculty or the admin.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>

</html>