<?php
include('db.php');
session_start();

// Ensure the user is logged in as an organization
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

// Validate inputs
if (!isset($_GET['id']) || !isset($_GET['action'])) {
    die("Invalid request.");
}

$applicationID = (int)$_GET['id'];
$action = $_GET['action'];

// Check if the application exists
$checkQuery = "SELECT * FROM applications WHERE ApplicationID = $applicationID";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows === 0) {
    die("Application not found.");
}

// Process the action
if ($action === 'approve') {
    $updateQuery = "UPDATE applications SET Status = 'Approved' WHERE ApplicationID = $applicationID";
    if ($conn->query($updateQuery)) {
        echo "<script>alert('Application approved successfully.');</script>";
    } else {
        echo "<script>alert('Error approving application.');</script>";
    }
} elseif ($action === 'reject') {
    $updateQuery = "UPDATE applications SET Status = 'Rejected' WHERE ApplicationID = $applicationID";
    if ($conn->query($updateQuery)) {
        echo "<script>alert('Application rejected successfully.');</script>";
    } else {
        echo "<script>alert('Error rejecting application.');</script>";
    }
} else {
    die("Invalid action.");
}

// Redirect back to the organization dashboard
echo "<script>window.location.href = 'org_dashboard.php';</script>";
?>
