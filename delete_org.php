<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $org_id = $_GET['id'];
    $query = "DELETE FROM organizations WHERE OrgID = '$org_id'";
    if ($conn->query($query)) {
        echo "<script>alert('Organization deleted successfully!'); window.location.href = 'list_organizations.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }
}
?>
