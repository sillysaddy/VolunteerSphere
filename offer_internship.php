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
    <title>Offer Internship</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Offer Internship</h1>
        <p>You are offering an internship to: <strong><?php echo htmlspecialchars($volunteer['Name']); ?></strong></p>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="internship_position" class="form-label">Select Internship Position</label>
                <select name="internship_position" id="internship_position" class="form-select" required>
                    <option value="">Select a position</option>
                    <?php if ($internshipResult->num_rows > 0): ?>
                        <?php while ($internship = $internshipResult->fetch_assoc()): ?>
                            <option value="<?php echo $internship['InternID']; ?>">
                                <?php echo htmlspecialchars($internship['Position']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">No internship positions available</option>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Offer Internship</button>
            <a href="org_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>




