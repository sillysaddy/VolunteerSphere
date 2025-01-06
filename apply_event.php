<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('db.php');
session_start();

// Ensure the user is logged in as a volunteer
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

// Check if the EventID is passed
if (isset($_GET['EventID'])) {
    $eventID = intval($_GET['EventID']); // Get the EventID from the URL
    $volunteerID = $_SESSION['user_id']; // Get the VolunteerID from the session

    // Check if the volunteer has already applied for this event
    $checkQuery = "SELECT * FROM applications WHERE VolunteerID = $volunteerID AND EventID = $eventID";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Volunteer has already applied for this event
        echo "<script>alert('You have already applied for this event.'); window.location.href='volunteer_dashboard.php';</script>";
    } else {
        // Insert the application into the database
        $applyQuery = "INSERT INTO applications (VolunteerID, EventID) VALUES ($volunteerID, $eventID)";
        if ($conn->query($applyQuery)) {
            echo "<script>alert('You have successfully applied for the event!'); window.location.href='volunteer_dashboard.php';</script>";
        } else {
            die("Error applying for the event: " . $conn->error);
        }
    }
} else {
    // If EventID is not passed, redirect back to the dashboard
    header("Location: volunteer_dashboard.php");
    exit();
}
?>

