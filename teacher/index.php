<?php
session_start();
include '../includes/connection.php';


if (isset($_SESSION['teacher_id']) || isset($_COOKIE['teacher_id'])) {
    header('location: dashboard.php');
    exit();
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_tutor = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE email = ? AND password = ? LIMIT 1");
    $select_tutor->execute([$email, $pass]);
    $row = $select_tutor->fetch(PDO::FETCH_ASSOC);

    if ($select_tutor->rowCount() > 0) {
       
        $_SESSION['teacher_id'] = $row['teacher_id'];
        $_SESSION['last_activity'] = time();

        setcookie('teacher_id', $row['teacher_id'], time() + 60 * 60 * 24 * 30, '/');

        header('location: dashboard.php');
        exit();
    } else {
        $message[] = 'Incorrect email or password!';
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

</head>

<body>

    <div class="container">
        <div class="form-container">
           <center> <h1> <b>TEACHER LOGIN</b> </h1></center>
            <br> 
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" autocomplete="off" placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="pass" placeholder="Enter your password">
                </div>
                <br> 
                <button type="submit" name="submit">Login</button>
            </form>
        </div>
        <div class="image-container">
          <center><img style="height: 450px;" src="https://scontent.fcgy2-1.fna.fbcdn.net/v/t39.30808-6/353832082_590289946586763_3338392738682972305_n.jpg?_nc_cat=1&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeEw87IyDVvsp_wvd-8TDhYw4sTCzPSrp3jixMLM9KuneDQH4QvqHuXjlytLkiWPGmR1T2t4NqfcV21CzOTQTf5c&_nc_ohc=v4mCj6xNntEAX8D5gM2&_nc_ht=scontent.fcgy2-1.fna&oh=00_AfDuy-QlmMDLjRW-AQ7IeN4GcpvLOj-eB4O890jxLyVa3Q&oe=65F86DD5" alt="COC SHIT">
      </center>    </div>
    </div>

</body>

</html>
