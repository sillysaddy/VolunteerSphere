<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $volunteer_id = $_SESSION['user_id'];
    $opportunity_id = $_POST['opportunity_id'];

    $query = "INSERT INTO applications (VolunteerID, OpportunityID) VALUES ('$volunteer_id', '$opportunity_id')";
    if ($conn->query($query)) {
        echo "<script>alert('Application submitted successfully!'); window.location.href = 'volunteer_opportunities.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }
}
?>
