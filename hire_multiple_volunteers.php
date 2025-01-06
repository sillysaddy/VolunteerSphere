<?php
include('db.php');
session_start();

// Ensure the user is logged in as an organization
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

// Initialize an empty array for hired volunteers
$hiredVolunteers = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_volunteers']) && is_array($_POST['selected_volunteers'])) {
        $selectedVolunteers = $_POST['selected_volunteers'];
        $orgID = $_SESSION['user_id'];

        foreach ($selectedVolunteers as $volunteerID) {
            $volunteerID = (int)$volunteerID;

            // Insert hire request into the `hires` table
            $insertQuery = "INSERT INTO hires (OrgID, VolunteerID, HireDate, Status) 
                            VALUES ($orgID, $volunteerID, CURDATE(), 'Pending')";
            $conn->query($insertQuery);

            // Fetch the volunteer's details for display
            $volunteerQuery = "SELECT Name, Email FROM volunteers WHERE VolunteerID = $volunteerID";
            $volunteerResult = $conn->query($volunteerQuery);
            if ($volunteerResult && $volunteerResult->num_rows > 0) {
                $volunteer = $volunteerResult->fetch_assoc();
                $hiredVolunteers[] = $volunteer;
            }
        }
    } else {
        // If no volunteers are selected, redirect back to the dashboard
        echo "<script>alert('No volunteers selected. Please select at least one volunteer.');</script>";
        echo "<script>window.location.href = 'org_dashboard.php';</script>";
        exit();
    }
} else {
    // If accessed directly, redirect back to the dashboard
    echo "<script>window.location.href = 'org_dashboard.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiring Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Hiring Summary</h1>
        <p class="text-center">Your hire requests have been successfully submitted. The following volunteers will be contacted via email.</p>

        <?php if (!empty($hiredVolunteers)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hiredVolunteers as $index => $volunteer): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($volunteer['Name']); ?></td>
                                <td><?php echo htmlspecialchars($volunteer['Email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No volunteers were hired. Please try again.</p>
        <?php endif; ?>

        <div class="mt-5 text-center">
            <a href="org_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>

