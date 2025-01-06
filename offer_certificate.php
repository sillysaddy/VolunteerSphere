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
    <title>Offer Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Offer Certificate</h1>
        <p>You are offering a certificate to: <strong><?php echo htmlspecialchars($volunteer['Name']); ?></strong></p>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="description" class="form-label">Certificate Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Offer Certificate</button>
            <a href="org_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>



