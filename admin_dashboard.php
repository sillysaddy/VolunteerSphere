<?php
include('db.php');
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM volunteers WHERE Approved = 0";
$result = $conn->query($query);

echo "Welcome to the Admin Dashboard, " . $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Approval Requests</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Volunteer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Qualifications</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['VolunteerID']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Phone']; ?></td>
                        <td><?php echo $row['Qualifications']; ?></td>
                        <td>
                            <form action="approve_volunteer.php" method="POST" style="display:inline;">
                                <input type="hidden" name="volunteer_id" value="<?php echo $row['VolunteerID']; ?>">
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="reject_volunteer.php" method="POST" style="display:inline;">
                                <input type="hidden" name="volunteer_id" value="<?php echo $row['VolunteerID']; ?>">
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
