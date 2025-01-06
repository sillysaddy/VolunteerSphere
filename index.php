<?php
session_start();

// Redirect to the respective dashboard if the user is already logged in
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
    // Redirect based on the role
    if ($_SESSION['role'] === 'volunteer') {
        header("Location: volunteer_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'organization') {
        header("Location: org_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VolunteerSphere</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">VolunteerSphere</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="display-4">Welcome to VolunteerSphere</h1>
            <p class="lead">Your one-stop platform for volunteers, organizations, and admins to connect and collaborate!</p>
            <?php if (!isset($_SESSION['user'])): ?>
                <a href="login.php" class="btn btn-primary btn-lg me-2">Login</a>
                <a href="register.php" class="btn btn-success btn-lg">Register</a>
            <?php else: ?>
                <a href="volunteer_dashboard.php" class="btn btn-success btn-lg">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <h3>Find Opportunities</h3>
                <p>Match with organizations based on your skills and interests.</p>
                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'volunteer'): ?>
                    <a href="volunteer_dashboard.php?skill_search=1" class="btn btn-primary">Skill-Based Search</a>
                <?php else: ?>
                    <p class="text-muted">Login as a volunteer to use this feature.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-4 text-center">
                <h3>Request Emergency Help</h3>
                <p>Get immediate help and tools from organizations.</p>
                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'volunteer'): ?>
                    <a href="volunteer_dashboard.php?emergency_help=1" class="btn btn-warning">Emergency Assistance</a>
                <?php else: ?>
                    <p class="text-muted">Login as a volunteer to use this feature.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-4 text-center">
                <h3>Join Events</h3>
                <p>Browse and apply for events organized by NGOs and groups.</p>
                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'volunteer'): ?>
                    <a href="volunteer_dashboard.php" class="btn btn-success">View Events</a>
                <?php else: ?>
                    <p class="text-muted">Login to browse events.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>




