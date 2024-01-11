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

        $stmt = $conn->prepare("SELECT `admin_id`, `email` FROM `tbl_admin` WHERE `email`=:email AND `password`=:password");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['loggedin'] = true;
            $_SESSION['admin_id'] = $row['admin_id'];
            header("Location: home.php");
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

if (isset($_SESSION['admin_id']) && isset($_SESSION['loggedin'])) {
    header('Location: home.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login-style.css">
</head>

<body>
    <div class="container">
        <div class="login-card">
            <h2>Login</h2>
            <form method="post">
                <label for="email">Email Address:</label>
                <input type="text" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <span style="color: red; margin-bottom: 12px;">
                    <?php echo $message ?>
                </span>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

</html>