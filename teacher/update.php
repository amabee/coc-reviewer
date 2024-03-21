<?php
session_start();
include '../includes/connection.php';

if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];
} else {
    $teacher_id = '';
    header('location:index.php');
}

if (isset($_SESSION["update_pass_alert"])) {
    $message[] = "Please update your default password to a new one";
}

if (isset($_POST['submit'])) {
    $select_teacher = $conn->prepare("SELECT * FROM `tbl_teachers` WHERE teacher_id = ? LIMIT 1");
    $select_teacher->execute([$teacher_id]);
    $fetch_teacher = $select_teacher->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_teacher['password'];
    $prev_image = $fetch_teacher['image'];

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `tbl_teachers` SET firstname = ? WHERE teacher_id = ?");
        $update_name->execute([$name, $teacher_id]);
        $message[] = 'Username updated successfully!';
    }

    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT email FROM `tbl_teachers` WHERE teacher_id = ? AND email = ?");
        $select_email->execute([$teacher_id, $email]);
        if ($select_email->rowCount() > 0) {
            $message[] = 'Email already taken!';
        } else {
            $update_email = $conn->prepare("UPDATE `tbl_teachers` SET email = ? WHERE teacher_id = ?");
            $update_email->execute([$email, $teacher_id]);
            $message[] = 'Email updated successfully!';
        }
    }

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = random_string() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../tmp/' . $rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Image size too large!';
        } else {
            $update_image = $conn->prepare("UPDATE `tbl_teachers` SET `image` = ? WHERE teacher_id = ?");
            $update_image->execute([$rename, $teacher_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($prev_image != '' and $prev_image != $rename) {
                unlink('../tmp/' . $prev_image);
            }
            $message[] = 'Image updated successfully!';
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    // Password policy enforcement
    $passwordPolicyMessage = enforce_password_policy($_POST['new_pass']);
    if ($passwordPolicyMessage !== "") {
        $message[] = $passwordPolicyMessage;
    } else {
        if ($old_pass != $empty_pass) {
            if ($old_pass != $prev_pass) {
                $message[] = 'Old password not matched!';
            } elseif ($new_pass != $cpass) {
                $message[] = 'Confirm password not matched!';
            } else {
                if ($new_pass != $empty_pass) {
                    $update_pass = $conn->prepare("UPDATE `tbl_teachers` SET password = ? WHERE teacher_id = ?");
                    $update_pass->execute([$cpass, $teacher_id]);
                    $message[] = 'Password updated successfully!';
                } else {
                    $message[] = 'Please enter a new password!';
                }
            }
        }
    }
}

function random_string()
{
    $str = random_bytes(16);
    $str = base64_encode($str);
    $str = str_replace(["+", "/", "="], "", $str);
    $str = substr($str, 0, 16);
    return $str;
}

function enforce_password_policy($password)
{
    $minLength = 8; 
    $requiresSpecialChar = true; 
    $requiresNumber = true; 
    $requiresAlpha = true; 

    if (stripos($password, 'password') !== false) {
        return "Choosen password is too weak, try a stronger one said goku";
    }

    if (strlen($password) < $minLength) {
        return "Password must be at least $minLength characters long!";
    }

    if ($requiresSpecialChar && !preg_match('/[\'^£$%&*()}{@#~!?><>,|=_+¬-]/', $password)) {
        return "Password must contain at least one special character!";
    }


    if ($requiresNumber && !preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number!";
    }

    if ($requiresAlpha && !preg_match('/[a-zA-Z]/', $password)) {
        return "Password must contain at least one alphabet character!";
    }

    return "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="styles/main_style.css">

</head>

<body>

    <?php include '../includes/teacher_header.php'; ?>

    <!-- register section starts  -->

    <section class="form-container" style="min-height: calc(100vh - 19rem);">

        <form class="register" action="" method="post" enctype="multipart/form-data">
            <h3>Update Profile</h3>
            <div class="flex">
                <div class="col">
                    <p>Your name </p>
                    <input type="text" name="name" placeholder="<?= $fetch_profile['firstname']; ?>" maxlength="50" class="box">
                    <p>Your email </p>
                    <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box">
                </div>
                <div class="col">
                    <p>Old password :</p>
                    <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" minlength="10" class="box">
                    <p>New password :</p>
                    <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" minlength="10" class="box">
                    <p>Confirm password :</p>
                    <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" minlength="10" class="box">
                </div>
            </div>
            <p>Update pic :</p>
            <input type="file" name="image" accept="image/*" class="box">
            <input type="submit" name="submit" value="Update Now" class="btn">
        </form>

    </section>

    <!-- register section ends -->

    <script src="../scripts/script.js"></script>

</body>

</html>