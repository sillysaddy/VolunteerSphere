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
    <title>Admin Dashboard - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">VolunteerSphere Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="logout.php" class="text-gray-600 hover:text-indigo-600 font-medium">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
            <p class="mt-2 text-gray-600">Overview of platform activities</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Volunteers Card -->
            <a href="list_volunteers.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Total Volunteers</h3>
                    <span class="text-2xl font-bold text-indigo-600"><?php echo $totalVolunteers; ?></span>
                </div>
            </a>

            <!-- Organizations Card -->
            <a href="list_org.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Total Organizations</h3>
                    <span class="text-2xl font-bold text-green-600"><?php echo $totalOrganizations; ?></span>
                </div>
            </a>

            <!-- Hired Volunteers Card -->
            <a href="list_hired_volunteers.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Hired Volunteers</h3>
                    <span class="text-2xl font-bold text-yellow-600"><?php echo $totalHiredVolunteers; ?></span>
                </div>
            </a>

            <!-- Applications Card -->
            <a href="list_applications.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Applications</h3>
                    <span class="text-2xl font-bold text-red-600"><?php echo $totalApplications; ?></span>
                </div>
            </a>

            <!-- Emergency Requests Card -->
            <a href="list_emergency_requests.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Emergency Requests</h3>
                    <span class="text-2xl font-bold text-orange-600"><?php echo $totalEmergencyRequests; ?></span>
                </div>
            </a>

            <!-- Rewards Claimed Card -->
            <a href="list_rewards_claimed.php" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Rewards Claimed</h3>
                    <span class="text-2xl font-bold text-purple-600"><?php echo $totalRewardsClaimed; ?></span>
                </div>
            </a>
        </div>
    </div>
</body>
</html>
