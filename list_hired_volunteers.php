<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch hired volunteers
$query = "
    SELECT v.Name AS VolunteerName, o.Name AS OrganizationName, h.HireDate
    FROM hires h
    JOIN volunteers v ON h.VolunteerID = v.VolunteerID
    JOIN organizations o ON h.OrgID = o.OrgID
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
    <title>Hired Volunteers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Hired Volunteers</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Volunteer Name</th>
                        <th>Organization Name</th>
                        <th>Hire Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['VolunteerName']); ?></td>
                            <td><?php echo htmlspecialchars($row['OrganizationName']); ?></td>
                            <td><?php echo htmlspecialchars($row['HireDate']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hired volunteers found.</p>
        <?php endif; ?>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>
