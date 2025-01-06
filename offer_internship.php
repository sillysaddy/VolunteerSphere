<?php
include('db.php');
session_start();

// Ensure the user is logged in as an organization
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

// Validate VolunteerID
if (!isset($_GET['VolunteerID'])) {
    die("Invalid request.");
}
$volunteerID = (int)$_GET['VolunteerID'];

// Fetch volunteer details
$volunteerQuery = "SELECT * FROM volunteers WHERE VolunteerID = $volunteerID";
$volunteerResult = $conn->query($volunteerQuery);
if ($volunteerResult->num_rows === 0) {
    die("Volunteer not found.");
}
$volunteer = $volunteerResult->fetch_assoc();

// Fetch available internship positions
$orgID = $_SESSION['user_id'];
$internshipQuery = "SELECT InternID, Position FROM internship WHERE OrgID = $orgID";
$internshipResult = $conn->query($internshipQuery);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $internID = $_POST['internship_position'];

    if (empty($internID)) {
        echo "<script>alert('Please select an internship position.');</script>";
    } else {
        $insertQuery = "INSERT INTO internship_offers (VolunteerID, OrgID, InternID) VALUES ($volunteerID, $orgID, $internID)";
        if ($conn->query($insertQuery)) {
            echo "<script>alert('Internship offered successfully!');</script>";
            echo "<script>window.location.href = 'org_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error offering internship.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Internship - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Offer Internship</h1>
            <p class="text-gray-600">You are offering an internship to: 
                <span class="font-semibold text-indigo-600"><?php echo htmlspecialchars($volunteer['Name']); ?></span>
            </p>
        </div>

        <form action="" method="POST" class="mt-8 space-y-6">
            <div>
                <label for="internship_position" class="block text-sm font-medium text-gray-700 mb-2">
                    Select Internship Position
                </label>
                <select name="internship_position" 
                        id="internship_position" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    <option value="">Select a position</option>
                    <?php if ($internshipResult->num_rows > 0): ?>
                        <?php while ($internship = $internshipResult->fetch_assoc()): ?>
                            <option value="<?php echo $internship['InternID']; ?>">
                                <?php echo htmlspecialchars($internship['Position']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="" disabled>No internship positions available</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="flex gap-4 justify-center">
                <button type="submit" 
                        class="inline-flex justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Offer Internship
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
