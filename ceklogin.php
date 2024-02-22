<?php
require_once "lib/database.php";
require_once "lib/validation.php";
require_once "lib/auth.php";

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $attempted = attempt_login($username, $password);
    if (!$attempted) {
        header("location: login.php?alertType=error&alertMessage=Login+Gagal");
        die();
    } else {
        header("location: index.php");
        die();
    }
} else {
    header("location: login.php");
    die();
}