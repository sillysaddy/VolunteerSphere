<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$volunteerQuery = "SELECT * FROM volunteers";
$volunteerResult = $conn->query($volunteerQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Volunteers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>List of Volunteers</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Qualifications</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($volunteer = $volunteerResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $volunteer['VolunteerID']; ?></td>
                        <td><?php echo $volunteer['Name']; ?></td>
                        <td><?php echo $volunteer['Email']; ?></td>
                        <td><?php echo $volunteer['Phone']; ?></td>
                        <td><?php echo $volunteer['Qualifications']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</body>
</html>
