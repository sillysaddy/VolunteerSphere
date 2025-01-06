<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch emergency requests
$query = "
    SELECT ar.RequestID, v.Name AS VolunteerName, o.Name AS OrgName, ea.SupportTool, ar.RequestDate
    FROM assistance_requests ar
    JOIN volunteers v ON ar.VolunteerID = v.VolunteerID
    JOIN emergencyassistance ea ON ar.AssistanceID = ea.AssistanceID
    JOIN organizations o ON ea.OrgID = o.OrgID;
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Emergency Requests</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Volunteer Name</th>
                    <th>Organization Name</th>
                    <th>Support Tool</th>
                    <th>Request Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['RequestID']); ?></td>
                        <td><?php echo htmlspecialchars($row['VolunteerName']); ?></td>
                        <td><?php echo htmlspecialchars($row['OrgName']); ?></td>
                        <td><?php echo htmlspecialchars($row['SupportTool']); ?></td>
                        <td><?php echo htmlspecialchars($row['RequestDate']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
