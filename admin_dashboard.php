<?php
include('db.php');
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

echo "Welcome to the Admin Dashboard, " . $_SESSION['user'];
?>
