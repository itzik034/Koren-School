<?php

include("../config/connection.php");
include("../helpers/function.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
} else {
    die("syntax error");
}

if ($action == "check_login") {
    $l_email = $_POST['l_email'];
    $l_pass = $_POST['l_pass'];
    $sql = "SELECT * FROM users WHERE `email` = '{$l_email}' AND `password` = '{$l_pass}' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_rank'] = $row['rank'];
        }

        echo 1;
    } else {
        echo 0;
    }
}

if ($action == "check_user_ava") {
    $s_email = $_POST['s_email'];
    $sql = "SELECT * FROM users WHERE `email` = '{$s_email}' LIMIT 1";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) == 0) {
        echo 1;
    } else {
        echo 0;
    }
}

if ($action == "sign_up_user") {
    $s_email = $_POST['s_email'];
    $s_phone = $_POST['s_phone'];
    $s_pass = $_POST['s_pass'];
    $s_f_name = $_POST['s_f_name'];
    $s_l_name = $_POST['s_l_name'];

    $sql = "INSERT INTO `users`(`password`, `email`, `email-confirm`, `user-register_date`, `rank`, `user-status`, `user-first_name`, `user-last_name`, `user-phone`) 
            VALUES ('{$s_pass}','{$s_email}','0',NOW(),'s','active','{$s_f_name}','{$s_l_name}', '{$s_phone}')";
    mysqli_query($conn, $sql) or die('0');

    function login($conn, $email)
    {
        $lo_sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $lo_query = mysqli_query($conn, $lo_sql);
        if (mysqli_num_rows($lo_query) > 0) {
            while ($row = mysqli_fetch_array($lo_query)) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_rank'] = $row['rank'];
            }
        }
    }

    login($conn, $s_email);

    echo 1;
}

if ($action == "get_current_user") {
    echo $_SESSION['user_id'];
}

if ($action == "get_current_user_rank") {
    echo $_SESSION['user_rank'];
}

?>