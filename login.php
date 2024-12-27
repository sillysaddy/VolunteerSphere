<?php
include('db.php');
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Role selection: Volunteer, Organization, Admin

    // Check login based on role
    if ($role === 'volunteer') {
        $query = "SELECT * FROM volunteers WHERE Email='$email'";
    } elseif ($role === 'organization') {
        $query = "SELECT * FROM organizations WHERE Email='$email'";
    } elseif ($role === 'admin') {
        $query = "SELECT * FROM admin WHERE Email='$email'";
    } else {
        $query = null;
    }

    if ($query) {
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Direct password comparison instead of password_verify
            if ($password === $user['password']) { // Note: case-sensitive field name 'password'
                $_SESSION['user'] = $user['Name'] ?? $user['username']; // Fallback for admin
                $_SESSION['role'] = $role;
                $_SESSION['user_id'] = $user['VolunteerID'] ?? $user['OrgID'] ?? $user['AdminID'];

                // Redirect based on role
                if ($role === 'volunteer') {
                    header("Location: volunteer_dashboard.php");
                } elseif ($role === 'organization') {
                    header("Location: organization_dashboard.php"); 
                } elseif ($role === 'admin') {
                    header("Location: admin_dashboard.php");
                }
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found with this email.";
        }
    } else {
        $error = "Invalid role selected.";
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
            <div class="mb-3">
                <label for="role" class="form-label">Login As</label>
                <select name="role" class="form-select" required>
                    <option value="volunteer">Volunteer</option>
                    <option value="organization">Organization</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
