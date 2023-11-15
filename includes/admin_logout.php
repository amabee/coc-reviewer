<?php
include 'connection.php';

session_start();
session_unset();


session_destroy();
setcookie('teacher_id', '', time() - 1, '/');
header('location:../teacher/index.php');

?>