<?php
include 'includes/connection.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();

if (isset($_COOKIE['user_id']) || isset($_SESSION['user_id'])) {
    $user_id = $_COOKIE['user_id'];
    header('Location: student/home.php');
    exit;
}

if (isset($_POST['submit'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = $_POST['pass'];
    $hashed_password = sha1($password);

    $select_user = $conn->prepare("SELECT id, password FROM `tbl_students` WHERE email = ? LIMIT 1");
    $select_user->execute([$email]);

    if ($select_user->rowCount() > 0) {
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($hashed_password === $row['password']) {
            setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
            $_SESSION['user_id'] = $row['id'];
            header('Location: student/home.php');
            exit;
        } else {
            // Credentials are invalid; set an error message.
            $error_message = 'Incorrect email or password!';
            echo "<script>document.addEventListener('DOMContentLoaded', function() {
                $('#invalidCredentialsModal').modal('show');
            });</script>";
        }
    } else {
        // User not found; set an error message.
        $error_message = 'User not found!';
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
            $('#invalidCredentialsModal').modal('show');
        });</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <title>Login</title>
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
                                        <input id="inputEmail" type="email" placeholder="Email address" name="email"
                                            required autofocus=""
                                            class="form-control rounded-pill border-0 shadow-sm px-4">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input id="inputPassword" type="password" placeholder="Password" name="pass"
                                            required
                                            class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    </div>
                                    <div
                                        class="custom-control custom-checkbox mb-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <input id="customCheck1" type="checkbox" checked
                                                class="custom-control-input">
                                            <label for="customCheck1" class="custom-control-label">Remember
                                                password</label>
                                        </div>
                                        <div>
                                            <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                                                data-bs-target="#accountProblem">No account yet?</a>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit"
                                        class="btn btn-success btn-block text-uppercase mb-2 rounded-pill shadow-sm">Sign
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


    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger text-center">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div id="invalidCredentialsModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <img src="assets/undraw_warning_re_eoyh.svg" class="img-thumbnail"
                        style="background-color: transparent; border:0;" alt="">
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


    <div id="accountProblem" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <img src="assets/undraw_contact_us_re_4qqt.svg" class="img-thumbnail"
                        style="background-color: transparent; border:0;" alt="">
                </div>
                <div class="modal-body text-center">
                    <h4>Please contact the Admin or Faculty!</h4>
                    <p>Account creation is handled by the faculty or the admin.</p>
                </div>
            </div>
        </div>
    </div>


</body>

</html>