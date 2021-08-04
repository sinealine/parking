<?php
//load the database configuration first.
require_once("session.php");
require_once("config.php");
// Logout data
if (!empty($_SESSION)) {
    $u_id = $_SESSION['u_id'];
    $stn_id = $_SESSION['stn_id'];
    $user_access = $_SESSION['user_access'];
    $function = $_SESSION['function'];
    $names = $_SESSION['names'];
    $email = $_SESSION['email'];
    $last_ID = $_SESSION['last_ID'];
}