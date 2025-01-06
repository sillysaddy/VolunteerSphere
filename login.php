<?php
include('db.php');
session_start();

// Redirect to the appropriate dashboard if the user is already logged in
if (isset($_SESSION['user']) && isset($_SESSION['role'])) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Escaping password for safety
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Prepare the query based on the role
    if ($role === 'volunteer') {
        $query = "SELECT * FROM volunteers WHERE Email = '$email'";
    } elseif ($role === 'organization') {
        $query = "SELECT * FROM organizations WHERE Email = '$email'";
    } elseif ($role === 'admin') {
        $query = "SELECT * FROM admin WHERE Email = '$email'";
    } else {
        $error = "Invalid role selected.";
        $query = null;
    }

    if ($query) {
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if the plain-text password matches
            if ($password === $user['Password']) {
                // Set session variables
                $_SESSION['user'] = $user['Name'] ?? $user['username']; // 'Name' for volunteers/organizations, 'username' for admin
                $_SESSION['role'] = $role;
                $_SESSION['user_id'] = $user['VolunteerID'] ?? $user['OrgID'] ?? $user['AdminID']; // Set the correct user ID

                // Redirect based on role
                if ($role === 'volunteer') {
                    header("Location: volunteer_dashboard.php");
                } elseif ($role === 'organization') {
                    header("Location: org_dashboard.php");
                } elseif ($role === 'admin') {
                    header("Location: admin_dashboard.php");
                }
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No user found with this email.";
        }
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
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
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
            <div class="mb-3">
                <label for="role" class="form-label">Login As</label>
                <select name="role" class="form-control" required>
                    <option value="volunteer">Volunteer</option>
                    <option value="organization">Organization</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        <div class="mt-3">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>



