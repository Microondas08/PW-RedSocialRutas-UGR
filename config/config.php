<?php
ob_start(); //Turns on output buffering 
session_start();

$timezone = date_default_timezone_set("Europe/London");

//Connection variable
$con = mysqli_connect("localhost", "root", "", "redsocialrutas");

if (mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
}


// Check the token on each request
/*
if (isset($_SESSION['token']) && isset($_REQUEST['token']) && $_SESSION['token'] === $_REQUEST['token']) {
    // Token is valid
} else {
    // Token is invalid, redirect to login page
    header('Location: login.php');
    exit();
}
?>
*/

