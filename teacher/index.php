<?php
session_start();
include '../includes/connection.php';

if (isset($_SESSION['teacher_id']) || isset($_COOKIE['teacher_id'])) {
    header('location: dashboard.php');
    exit();
}

$message = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Check if consecutive failed attempts session variable is set
    if (!isset($_SESSION['consecutive_failed_attempts'])) {
        $_SESSION['consecutive_failed_attempts'] = 0;
    }

    // Increment the count of consecutive failed attempts
    $_SESSION['consecutive_failed_attempts']++;

    if ($_SESSION['consecutive_failed_attempts'] >= 3) {
        $_SESSION['show_timer'] = true;
    }

    $select_tutor = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE email = ? AND password = ? LIMIT 1");
    $select_tutor->execute([$email, $pass]);
    $row = $select_tutor->fetch(PDO::FETCH_ASSOC);

    if ($select_tutor->rowCount() > 0) {
        $_SESSION['teacher_id'] = $row['teacher_id'];
        $_SESSION['last_activity'] = time();
        $_SESSION['consecutive_failed_attempts'] = 0; // Reset consecutive failed attempts

        setcookie('teacher_id', $row['teacher_id'], time() + 60 * 60 * 24 * 30, '/');

        header('location: dashboard.php');
        exit();
    } else {
        $message = 'Incorrect email or password!';
    }
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>
    <link rel="stylesheet" href="./styles/login.css">
    <style>
        .error-message {
            color: red;
        }

  

        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 100px;
            transition: background-color 0.3s;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <center>
                <h1><b>TEACHER LOGIN</b></h1>
            </center>
            <br>
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" autocomplete="off" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" onclick="hideErrorMessage()">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="pass" placeholder="Enter your password" onclick="hideErrorMessage()">
                </div>
                <br>
                <button type="submit" name="submit" id="loginButton" class="btn btn-primary btn-user btn-block mt-5">Login</button>

                <?php if (!empty($message)): ?>
                    <p class="error-message"><?php echo $message; ?></p>
                <?php endif; ?>
            </form>
        </div>
        <div class="image-container">
            <center>
                <img style="height: 450px;" src="https://scontent.fcgy2-2.fna.fbcdn.net/v/t39.30808-6/353832082_590289946586763_3338392738682972305_n.jpg?_nc_cat=1&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeEw87IyDVvsp_wvd-8TDhYw4sTCzPSrp3jixMLM9KuneDQH4QvqHuXjlytLkiWPGmR1T2t4NqfcV21CzOTQTf5c&_nc_ohc=o587yaeXTL8AX9dnlNO&_nc_ht=scontent.fcgy2-2.fna&oh=00_AfBgGtx-Ew9svkG8F8qQXBrX657GIMIPe8Rece9PBPz50g&oe=65FE5C95" alt="">
            </center>
        </div>
    </div>

    <?php if ($_SESSION['show_timer'] ?? false): ?>
        <script>
            var seconds = 10;
            var interval = setInterval(function() {
                document.getElementById('loginButton').textContent = 'Try Again in ' + seconds + ' seconds';
                document.getElementById('loginButton').classList.add('disabled');
                seconds--;
                if (seconds < 0) {
                    clearInterval(interval);
                    document.getElementById('loginButton').textContent = 'Login';
                    document.getElementById('loginButton').classList.remove('disabled');
                }
            }, 1000);
        </script>
    <?php endif; ?>

    <script>
        function hideErrorMessage() {
            document.querySelector('.error-message').textContent = '';
        }
    </script>
</body>

</html>
<script>
    var attempts = <?php echo isset($_SESSION['consecutive_failed_attempts']) ? $_SESSION['consecutive_failed_attempts'] : 0; ?>;
    var timerInterval;

    function startTimer() {
        var seconds = 10;
        document.getElementById('loginButton').setAttribute('disabled', 'disabled');
        document.getElementById('loginButton').style.backgroundColor = '#8CA4EA'; // Change button color to light gray
        document.getElementById('loginButton').style.cursor = 'not-allowed'; // Disable mouse pointer
        timerInterval = setInterval(function() {
            document.getElementById('loginButton').textContent = 'Try Again in ' + seconds + ' seconds';
            seconds--;
            if (seconds < 0) {
                clearInterval(timerInterval);
                document.getElementById('loginButton').textContent = 'Login';
                document.getElementById('loginButton').removeAttribute('disabled');
                document.getElementById('loginButton').style.backgroundColor = '#007bff'; // Restore original button color
                document.getElementById('loginButton').style.cursor = 'pointer'; // Restore mouse pointer
            }
        }, 1000);
    }

    if (attempts >= 3) {
        startTimer();
    }
</script>

