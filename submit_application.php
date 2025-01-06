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
    <title>Apply for Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Apply for Event</h1>
        <p><strong>Organization:</strong> <?php echo htmlspecialchars($event['OrgName']); ?></p>
        <p><strong>Event Name:</strong> <?php echo htmlspecialchars($event['EventName']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($event['Description']); ?></p>
        <form method="POST" action="">
            <p>Are you sure you want to apply for this event?</p>
            <button type="submit" name="confirm" value="yes" class="btn btn-success">Yes, Apply</button>
            <a href="volunteer_dashboard.php" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</body>
</html>



