<?php
include('db.php');
session_start();

if ($_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

echo "Welcome to the Volunteer Dashboard, " . $_SESSION['user'];
?>
