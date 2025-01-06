<?php
include('db.php');
session_start();

// Ensure the user is logged in as an organization
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

// Get VolunteerID from GET request
if (!isset($_GET['VolunteerID'])) {
    die("Invalid request.");
}
$volunteerID = (int)$_GET['VolunteerID'];

// Fetch volunteer details
$volunteerQuery = "SELECT Name FROM volunteers WHERE VolunteerID = $volunteerID";
$volunteerResult = $conn->query($volunteerQuery);
if ($volunteerResult->num_rows === 0) {
    die("Volunteer not found.");
}
$volunteer = $volunteerResult->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $orgID = $_SESSION['user_id'];

    // Insert the certificate into the database
    $insertQuery = "INSERT INTO certificates (VolunteerID, OrgID, Description, Date) VALUES ($volunteerID, $orgID, '$description', NOW())";
    if ($conn->query($insertQuery)) {
        echo "<script>alert('Certificate offered successfully.'); window.location.href = 'org_dashboard.php';</script>";
    } else {
        // Display the error message if the query fails
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Certificate - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Offer Certificate</h1>
            <p class="text-gray-600">You are offering a certificate to: 
                <span class="font-semibold text-indigo-600"><?php echo htmlspecialchars($volunteer['Name']); ?></span>
            </p>
        </div>

        <form method="POST" action="" class="mt-8 space-y-6">
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Certificate Description
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                          required></textarea>
            </div>

            <div class="flex gap-4 justify-center">
                <button type="submit" 
                        class="inline-flex justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Offer Certificate
                </button>
                <a href="org_dashboard.php" 
                   class="inline-flex justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>
