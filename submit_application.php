<?php
include('db.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

// Get EventID
if (!isset($_GET['EventID'])) {
    die("Invalid request.");
}
$eventID = (int)$_GET['EventID'];

// Fetch event details
$eventQuery = "SELECT e.EventName, e.Description, o.Name AS OrgName 
               FROM events e 
               JOIN organizations o ON e.OrgID = o.OrgID 
               WHERE e.EventID = $eventID";
$eventResult = $conn->query($eventQuery);
if (!$eventResult || $eventResult->num_rows == 0) {
    die("Event not found.");
}
$event = $eventResult->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $volunteerID = $_SESSION['user_id'];

        // Check if already applied
        $checkQuery = "SELECT * FROM applications WHERE VolunteerID = $volunteerID AND EventID = $eventID";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "<script>alert('You have already applied for this event.');</script>";
            echo "<script>window.location.href = 'volunteer_dashboard.php';</script>";
            exit();
        }

        // Insert the application
        $insertQuery = "INSERT INTO applications (VolunteerID, EventID, ApplicationDate, Status) 
                        VALUES ($volunteerID, $eventID, CURDATE(), 'Pending')";
        if ($conn->query($insertQuery)) {
            // Increment points by 30
            $updatePointsQuery = "UPDATE volunteers SET Points = Points + 30 WHERE VolunteerID = $volunteerID";
            $conn->query($updatePointsQuery);

            echo "<script>alert('Application submitted successfully! You earned 30 points.');</script>";
            echo "<script>window.location.href = 'volunteer_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error submitting the application.');</script>";
            echo "<script>window.location.href = 'volunteer_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Application canceled.');</script>";
        echo "<script>window.location.href = 'volunteer_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Event - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Apply for Event</h1>
            <p class="text-lg text-gray-600">Please review the event details below</p>
        </div>

        <!-- Event Details -->
        <div class="bg-gray-50 rounded-lg p-8 space-y-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Organization</h2>
                <p class="text-lg text-gray-700 mt-2"><?php echo htmlspecialchars($event['OrgName']); ?></p>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Event Name</h2>
                <p class="text-lg text-gray-700 mt-2"><?php echo htmlspecialchars($event['EventName']); ?></p>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Description</h2>
                <p class="text-lg text-gray-700 mt-2"><?php echo htmlspecialchars($event['Description']); ?></p>
            </div>
        </div>

        <!-- Confirmation Form -->
        <form method="POST" action="" class="mt-10 space-y-6">
            <div class="text-center">
                <p class="text-xl text-gray-600 mb-8">Are you sure you want to apply for this event?</p>
                <div class="flex gap-6 justify-center">
                    <button type="submit" 
                            name="confirm" 
                            value="yes" 
                            class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 min-w-[150px]">
                        Yes, Apply Now
                    </button>
                    <a href="volunteer_dashboard.php" 
                       class="inline-flex justify-center items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 min-w-[150px]">
                        Cancel
                    </a>
                </div>
            </div>
        </form>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="volunteer_dashboard.php" 
               class="text-sm text-gray-600 hover:text-indigo-600 transition-colors duration-200">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</body>
</html>
