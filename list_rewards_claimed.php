<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch rewards claimed
$query = "
    SELECT v.Name AS VolunteerName, r.Description AS RewardDescription, rc.ClaimDate
    FROM rewards_claimed rc
    JOIN volunteers v ON rc.VolunteerID = v.VolunteerID
    JOIN rewards r ON rc.RewardID = r.RewardID
";
$result = $conn->query($query);

// Debugging SQL
if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards Claimed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Rewards Claimed</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Volunteer Name</th>
                        <th>Reward Description</th>
                        <th>Claim Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['VolunteerName']); ?></td>
                            <td><?php echo htmlspecialchars($row['RewardDescription']); ?></td>
                            <td><?php echo htmlspecialchars($row['ClaimDate']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No rewards claimed found.</p>
        <?php endif; ?>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>

