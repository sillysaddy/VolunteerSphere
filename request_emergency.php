<?php
include('db.php');
session_start();

// Ensure the user is logged in as a volunteer
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

// Validate the AssistanceID from the GET request
if (!isset($_GET['AssistanceID']) || empty($_GET['AssistanceID'])) {
    die("Invalid request.");
}
$assistanceID = (int)$_GET['AssistanceID'];

// Fetch Assistance Details
$assistanceQuery = "
    SELECT ea.AssistanceID, o.Name AS OrgName, ea.SupportTool
    FROM emergencyassistance ea
    JOIN organizations o ON ea.OrgID = o.OrgID
    WHERE ea.AssistanceID = $assistanceID;
";
$assistanceResult = $conn->query($assistanceQuery);

if ($assistanceResult->num_rows === 0) {
    die("Assistance not found.");
}

$assistance = $assistanceResult->fetch_assoc();

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['submit'] === 'yes') {
        // Store the assistance request in the database
        $volunteerID = $_SESSION['user_id'];
        $insertQuery = "
            INSERT INTO assistance_requests (VolunteerID, AssistanceID, RequestDate, Status) 
            VALUES ($volunteerID, $assistanceID, NOW(), 'Pending');
        ";
        if ($conn->query($insertQuery)) {
            echo "<script>alert('Your request has been submitted successfully!');</script>";
            echo "<script>window.location.href = 'volunteer_dashboard.php';</script>";
        } else {
            echo "Error submitting request: " . $conn->error;
        }
    } else {
        echo "<script>alert('You canceled the request.');</script>";
        echo "<script>window.location.href = 'volunteer_dashboard.php';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Emergency Assistance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Request Emergency Assistance</h1>
        <p><strong>Organization:</strong> <?php echo htmlspecialchars($assistance['OrgName']); ?></p>
        <p><strong>Support Tool:</strong> <?php echo htmlspecialchars($assistance['SupportTool']); ?></p>

        <form method="POST">
            <p>Would you like to submit this request?</p>
            <button type="submit" name="submit" value="yes" class="btn btn-success">Yes</button>
            <button type="submit" name="submit" value="no" class="btn btn-danger">No</button>
        </form>
    </div>
</body>
</html>


