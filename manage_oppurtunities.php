<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM opportunities WHERE OrganizationID = '" . $_SESSION['user_id'] . "'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Opportunities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Opportunities</h1>
        <a href="create_opportunity.php" class="btn btn-success mb-3">Create New Opportunity</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Opportunity ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['OpportunityID']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['Location']; ?></td>
                        <td>
                            <a href="edit_opportunity.php?id=<?php echo $row['OpportunityID']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_opportunity.php?id=<?php echo $row['OpportunityID']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

