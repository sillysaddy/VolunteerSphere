<?php
include('db.php');
session_start();

if ($_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

echo "Welcome to the Organization Dashboard, " . $_SESSION['user'];
?>
