<?php
include('db.php');
session_start();

// Ensure the user is logged in as an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch counts for dashboard
$totalVolunteers = $conn->query("SELECT COUNT(*) AS count FROM volunteers")->fetch_assoc()['count'];
$totalOrganizations = $conn->query("SELECT COUNT(*) AS count FROM organizations")->fetch_assoc()['count'];
$totalHiredVolunteers = $conn->query("SELECT COUNT(DISTINCT VolunteerID) AS count FROM hires")->fetch_assoc()['count'];
$totalHires = $conn->query("SELECT COUNT(*) AS count FROM hires")->fetch_assoc()['count'];
$totalApplications = $conn->query("SELECT COUNT(*) AS count FROM applications")->fetch_assoc()['count'];
$totalEmergencyRequests = $conn->query("SELECT COUNT(*) AS count FROM assistance_requests")->fetch_assoc()['count'];
$totalRewardsClaimed = $conn->query("SELECT COUNT(*) AS count FROM rewards_claimed")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to the Admin Dashboard, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
        <p>Overview of platform activities:</p>
        <div class="row">
            <div class="col-md-3">
                <a href="list_volunteers.php" class="btn btn-primary w-100 mb-3">Total Volunteers: <?php echo $totalVolunteers; ?></a>
            </div>
            <div class="col-md-3">
                <a href="list_org.php" class="btn btn-success w-100 mb-3">Total Organizations: <?php echo $totalOrganizations; ?></a>
            </div>
            <div class="col-md-3">
                <a href="list_hired_volunteers.php" class="btn btn-warning w-100 mb-3">Hired Volunteers: <?php echo $totalHiredVolunteers; ?></a>
            </div>
            <div class="col-md-3">
                <a href="list_applications.php" class="btn btn-danger w-100 mb-3">Applications Submitted: <?php echo $totalApplications; ?></a>
            </div>
            <div class="col-md-3">
                <a href="list_emergency_requests.php" class="btn btn-secondary w-100 mb-3">Emergency Requests: <?php echo $totalEmergencyRequests; ?></a>
            </div>
            <div class="col-md-3">
                <a href="list_rewards_claimed.php" class="btn btn-info w-100 mb-3">Rewards Claimed: <?php echo $totalRewardsClaimed; ?></a>
            </div>
        </div>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>

