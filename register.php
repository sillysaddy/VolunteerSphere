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
    <title>Register - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Join VolunteerSphere and make a difference
            </p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <form class="mt-8 space-y-6" method="POST" action="">
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Full Name
                    </label>
                    <input type="text" id="name" name="name" required
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Enter your full name">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email Address
                    </label>
                    <input type="email" id="email" name="email" required
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Enter your email">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Create a password">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">
                        Register As
                    </label>
                    <select id="role" name="role" required
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="volunteer">Volunteer</option>
                        <option value="organization">Organization</option>
                    </select>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Account
                </button>
            </div>
        </form>

        <div class="text-center">
            <div class="flex items-center justify-center gap-2">
                <span class="text-gray-600">Already have an account?</span>
                <a href="login.php" class="text-indigo-600 font-semibold hover:text-indigo-800 transition-colors duration-200">
                    Sign in here
                </a>
            </div>
            <a href="index.php" class="text-gray-500 hover:text-gray-700 text-sm mt-3 inline-block transition-colors duration-200">
                ← Back to Home
            </a>
        </div>
    </div>
</body>
</html>
