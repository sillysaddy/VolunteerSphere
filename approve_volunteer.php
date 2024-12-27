<?php
include('db.php');
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $volunteer_id = $_POST['volunteer_id'];
    $query = "UPDATE volunteers SET Approved = 1 WHERE VolunteerID = '$volunteer_id'";
    if ($conn->query($query)) {
        echo "<script>alert('Volunteer approved successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }
}
?>