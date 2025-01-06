<?php
include('db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    if ($role === 'volunteer') {
        $query = "UPDATE notifications SET IsRead = 1 WHERE VolunteerID = ?";
    } elseif ($role === 'organization') {
        $query = "UPDATE notifications SET IsRead = 1 WHERE OrgID = ?";
    } else {
        exit;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
}
?>
