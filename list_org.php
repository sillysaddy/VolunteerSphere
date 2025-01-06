<?php
include('db.php');
session_start();

// Ensure the user is logged in as admin or organization
if (!isset($_SESSION['user']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'organization')) {
    header("Location: login.php");
    exit();
}

// Fetch all organizations from the database
$query = "SELECT * FROM organizations";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizations List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Organizations List</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="create_organization.php" class="btn btn-success">Add New Organization</a>
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Org ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['OrgID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['Type']); ?></td>
                            <td><?php echo htmlspecialchars($row['Address']); ?></td>
                            <td>
                                <a href="edit_organization.php?id=<?php echo $row['OrgID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_organization.php?id=<?php echo $row['OrgID']; ?>" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this organization?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-warning">No organizations found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

