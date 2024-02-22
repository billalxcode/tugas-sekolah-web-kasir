<?php
require_once "lib/database.php";

session_start();

function user_id_exists($user_id)
{
    global $connector;

    $user_data = $connector->query("SELECT * FROM `users` WHERE id = $user_id");
    return $user_data->num_rows > 0;
}

function user_username_exists($username) {
    global $connector;

    $user_data = $connector->query("SELECT * FROM `users` WHERE username = '$username'");
    return $user_data;
}

function check_session()
{
    $user_token = $_SESSION["token"];

    if (!$user_token) {
        header("location: login.php");
        die();
    }
    try {
        $user_data = base64_decode($user_token);
        $user_json = json_decode($user_data);
        $exists = user_id_exists($user_json->id);
        if (!$exists) {
            header("location: login.php");
            die();
        }
    } catch (Exception $e) {
        $message = urlencode($e->getMessage());
        header("location: login.php?alertType=error&alertMessage=$message");
        die();
    }
}

function logout() {
    session_destroy();
    header("location: login.php");
    die();
}

function generate_token($user_data) {
    $data_json = json_encode($user_data);
    $data_token = base64_encode($data_json);
    return $data_token;
}

function attempt_login($username, $password) {
    try {
        $user = user_username_exists($username);
        $user_exists = $user->num_rows > 0;
        if ($user_exists) {
            $user_data = $user->fetch_assoc();
            $hash_password = hash('md5', $password);
    
            if ($hash_password == $user_data['password']) {
                $_SESSION["token"] = generate_token($user_data);
                return true;
            } else {
                return false;
            }
        }
    } catch (Exception $e) {
        $message = urlencode($e->getMessage());
        header("location: login.php?alertType=error&alertMessage=$message");
        die();
    }
}