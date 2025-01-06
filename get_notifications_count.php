<?php
include('db.php');
include('notifications_helper.php');
session_start();

echo getUnreadNotificationsCount($_SESSION['user_id'], $_SESSION['role']);
?>
