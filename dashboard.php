<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user'];
$user_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">VolunteerSphere</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome, <?php echo $user_name; ?>!</h1>
        <p>Role: <?php echo ucfirst($user_role); ?></p>

        <?php if ($user_role === 'volunteer'): ?>
            <h3>Your Volunteer Dashboard</h3>
            <p>Here you can view and apply for volunteering opportunities.</p>
            <a href="volunteer_opportunities.php" class="btn btn-primary">View Opportunities</a>

        <?php elseif ($user_role === 'organization'): ?>
            <h3>Your Organization Dashboard</h3>
            <p>Here you can manage volunteer applications and post opportunities.</p>
            <a href="manage_opportunities.php" class="btn btn-primary">Manage Opportunities</a>
            <a href="list_organizations.php" class="btn btn-secondary">View All Organizations</a>

        <?php elseif ($user_role === 'admin'): ?>
            <h3>Admin Dashboard</h3>
            <p>Manage users, organizations, and oversee system activities.</p>
            <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
            <a href="list_organizations.php" class="btn btn-secondary">View/Edit Organizations</a>
            <a href="view_reports.php" class="btn btn-success">View Reports</a>

        <?php else: ?>
            <div class="alert alert-danger">Invalid role. Please contact support.</div>
        <?php endif; ?>
    </div>
</body>
</html>

