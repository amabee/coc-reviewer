<?php
include 'connection.php';

session_start();
session_unset();


session_destroy();
setcookie('user_id', '', time() - 1, '/');
header('location:../index.php');

?>