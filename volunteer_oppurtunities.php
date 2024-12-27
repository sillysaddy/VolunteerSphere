<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM opportunities";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Opportunities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Available Volunteering Opportunities</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Opportunity ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Action</th>
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
                            <form action="apply_opportunity.php" method="POST">
                                <input type="hidden" name="opportunity_id" value="<?php echo $row['OpportunityID']; ?>">
                                <button type="submit" class="btn btn-primary">Apply</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
