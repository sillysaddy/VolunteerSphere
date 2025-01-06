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
    <title>Hire Volunteer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Hire Volunteer</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($volunteer['Name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($volunteer['Email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($volunteer['Phone']); ?></p>
        <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($volunteer['Qualifications']); ?></p>
        <p><strong>Available for Emergency:</strong> <?php echo ($volunteer['EmergencyHelp'] == 1) ? 'Yes' : 'No'; ?></p>
        <form method="POST" action="">
            <p>Are you sure you want to hire this volunteer?</p>
            <button type="submit" name="confirm" value="yes" class="btn btn-success">Yes, Hire</button>
            <a href="org_dashboard.php" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</body>
</html>
