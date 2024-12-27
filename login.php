<?php
include('db.php');
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check login for volunteers
    $query = "SELECT * FROM volunteers WHERE Email='$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['Password']) {
            $_SESSION['user'] = $user['Name'];
            $_SESSION['role'] = 'volunteer';
            $_SESSION['user_id'] = $user['VolunteerID'];
            header("Location: volunteer_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    }

    // Check login for organizations
    $query = "SELECT * FROM organizations WHERE Email='$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['Password']) {
            $_SESSION['user'] = $user['Name'];
            $_SESSION['role'] = 'organization';
            $_SESSION['user_id'] = $user['OrgID'];
            header("Location: organization_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    }

    // Check login for admin
    $query = "SELECT * FROM admin WHERE Email='$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = 'admin';
            $_SESSION['user_id'] = $user['AdminID'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    }

    if (!isset($error)) {
        $error = "No user found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-secondary">Register</a>
        </form>
    </div>
</body>
</html>
