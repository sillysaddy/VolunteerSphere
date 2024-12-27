<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'organization')) {
    header("Location: login.php");
    exit();
}

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
        <a href="create_organization.php" class="btn btn-success mb-3">Add New Organization</a>
        <table class="table table-bordered table-striped">
            <thead>
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
                        <td><?php echo $row['OrgID']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Email']; ?></td>
                        <td><?php echo $row['Type']; ?></td>
                        <td><?php echo $row['Address']; ?></td>
                        <td>
                            <a href="edit_organization.php?id=<?php echo $row['OrgID']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_organization.php?id=<?php echo $row['OrgID']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
