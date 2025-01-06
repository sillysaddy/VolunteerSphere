<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

// Fetch rewards
$rewardsQuery = "SELECT * FROM rewards";
$rewardsResult = $conn->query($rewardsQuery);

// Fetch volunteer's points
$volunteerID = $_SESSION['user_id'];
$volunteerQuery = "SELECT Points FROM volunteers WHERE VolunteerID = $volunteerID";
$volunteerResult = $conn->query($volunteerQuery);
$volunteer = $volunteerResult->fetch_assoc();
$currentPoints = $volunteer['Points'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Rewards - VolunteerSphere</title>
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
                    <span class="text-2xl font-bold text-indigo-600">VolunteerSphere</span>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Points Display -->
                    <div class="bg-indigo-50 rounded-full px-4 py-2 flex items-center">
                        <span class="text-yellow-500 font-bold mr-2">★</span>
                        <span class="text-indigo-600 font-semibold"><?php echo $currentPoints; ?> Points</span>
                    </div>
                    <a href="volunteer_dashboard.php" class="text-gray-600 hover:text-indigo-600 font-medium">Dashboard</a>
                    <a href="logout.php" class="text-gray-600 hover:text-indigo-600 font-medium">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Claim Your Rewards</h1>
            <p class="text-lg text-gray-600">Turn your volunteer points into amazing rewards!</p>
        </div>

        <!-- Rewards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($reward = $rewardsResult->fetch_assoc()): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-baseline mb-4">
                            <span class="inline-flex items-center px-3 py-1 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-full">
                                <span class="text-yellow-500 mr-1">★</span>
                                <?php echo $reward['PointCost']; ?> Points
                            </span>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <?php echo htmlspecialchars($reward['Description']); ?>
                        </h2>
                        <div class="mt-4">
                            <?php if ($currentPoints >= $reward['PointCost']): ?>
                                <form method="POST" action="claim_reward.php">
                                    <input type="hidden" name="RewardID" value="<?php echo $reward['RewardID']; ?>">
                                    <button type="submit" name="claim" 
                                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                                        Claim Reward
                                    </button>
                                </form>
                            <?php else: ?>
                                <div class="relative">
                                    <button disabled 
                                        class="w-full bg-gray-200 text-gray-500 py-3 px-4 rounded-md cursor-not-allowed">
                                        Not Enough Points
                                    </button>
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                                        <span class="bg-black text-white text-sm py-1 px-2 rounded">
                                            You need <?php echo $reward['PointCost'] - $currentPoints; ?> more points
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
