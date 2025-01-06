<?php
include('db.php');
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if ($role === 'volunteer') {
        // Insert into `volunteers` table
        $query = "INSERT INTO volunteers (Name, Email, Password) VALUES ('$name', '$email', '$password')";
    } elseif ($role === 'organization') {
        // Insert into `organizations` table
        $query = "INSERT INTO organizations (Name, Email, Password) VALUES ('$name', '$email', '$password')";
    } else {
        die("Invalid role selected.");
    }

    if ($conn->query($query) === TRUE) {
        $_SESSION['success'] = "Registration successful! Please log in.";
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Register</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Register As</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="volunteer">Volunteer</option>
                    <option value="organization">Organization</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <a href="login.php" class="d-block mt-3">Already have an account? Login here.</a>
    </div>
</body>
</html>

