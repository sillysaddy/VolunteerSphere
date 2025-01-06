<?php
include('db.php');
session_start();

// Ensure the user is logged in as an organization
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

// Get VolunteerID
if (!isset($_GET['VolunteerID'])) {
    die("Invalid request.");
}
$volunteerID = (int)$_GET['VolunteerID'];

// Fetch volunteer details
$volunteerQuery = "SELECT * FROM volunteers WHERE VolunteerID = $volunteerID";
$volunteerResult = $conn->query($volunteerQuery);
if (!$volunteerResult || $volunteerResult->num_rows == 0) {
    die("Volunteer not found.");
}
$volunteer = $volunteerResult->fetch_assoc();

// Handle hire request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        // Insert into hires table
        $insertQuery = "INSERT INTO hires (OrgID, VolunteerID, HireDate, Status) 
                        VALUES ({$_SESSION['user_id']}, $volunteerID, CURDATE(), 'Pending')";
        if ($conn->query($insertQuery)) {
            echo "<script>alert('Hire request submitted successfully!');</script>";
            echo "<script>window.location.href = 'org_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error submitting the hire request.');</script>";
        }
    } else {
        echo "<script>alert('Hire request canceled.');</script>";
        echo "<script>window.location.href = 'org_dashboard.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hire Volunteer - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Hire Volunteer</h1>
            <p class="text-gray-600 mb-8">Review volunteer details before confirming</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-6 space-y-4">
            <div>
                <h2 class="text-sm font-medium text-gray-500">Name</h2>
                <p class="mt-1 text-lg text-gray-900"><?php echo htmlspecialchars($volunteer['Name']); ?></p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Email</h2>
                <p class="mt-1 text-lg text-gray-900"><?php echo htmlspecialchars($volunteer['Email']); ?></p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Phone</h2>
                <p class="mt-1 text-lg text-gray-900"><?php echo htmlspecialchars($volunteer['Phone']); ?></p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Qualifications</h2>
                <p class="mt-1 text-lg text-gray-900"><?php echo htmlspecialchars($volunteer['Qualifications']); ?></p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Available for Emergency</h2>
                <p class="mt-1 text-lg <?php echo ($volunteer['EmergencyHelp'] == 1) ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo ($volunteer['EmergencyHelp'] == 1) ? 'Yes' : 'No'; ?>
                </p>
            </div>
        </div>

        <form method="POST" action="" class="mt-8 space-y-6">
            <div class="text-center">
                <p class="text-gray-600 mb-4">Are you sure you want to hire this volunteer?</p>
                <div class="flex gap-4 justify-center">
                    <button type="submit" name="confirm" value="yes" 
                            class="inline-flex justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Yes, Hire
                    </button>
                    <a href="org_dashboard.php" 
                       class="inline-flex justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
