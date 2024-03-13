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
    <title>Faculty Login</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message form">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>
    <h1>Teacher Login</h1>
    <form method="POST">
        <div class="row">
            <label for="email">Email</label>
            <input type="email" name="email" autocomplete="off" placeholder="email@example.com">
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input type="password" name="pass">
        </div>
        <button type="submit" name="submit">Login</button>
    </form>
</body>

</html>