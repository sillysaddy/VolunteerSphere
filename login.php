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
    <title>Login - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-4 h-full">
        <div class="flex content-center items-center justify-center h-full">
            <div class="w-full lg:w-4/12 px-4">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white border-0">
                    <div class="rounded-t mb-0 px-6 py-6">
                        <div class="text-center mb-3">
                            <h1 class="text-3xl font-bold text-indigo-600">
                                Welcome Back
                            </h1>
                        </div>
                        <?php if (isset($error)): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <form action="login.php" method="POST">
                            <div class="relative w-full mb-5">
                                <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="email">
                                    Email Address
                                </label>
                                <input type="email" name="email" 
                                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-gray-50 rounded text-sm shadow focus:outline-none focus:ring-2 focus:ring-indigo-600 w-full"
                                    placeholder="Email" required />
                            </div>
                            <div class="relative w-full mb-5">
                                <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="password">
                                    Password
                                </label>
                                <input type="password" name="password"
                                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-gray-50 rounded text-sm shadow focus:outline-none focus:ring-2 focus:ring-indigo-600 w-full"
                                    placeholder="Password" required />
                            </div>
                            <div class="relative w-full mb-5">
                                <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="role">
                                    Login As
                                </label>
                                <select name="role" 
                                    class="border-0 px-3 py-3 placeholder-gray-400 text-gray-700 bg-gray-50 rounded text-sm shadow focus:outline-none focus:ring-2 focus:ring-indigo-600 w-full" 
                                    required>
                                    <option value="volunteer">Volunteer</option>
                                    <option value="organization">Organization</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="text-center mt-6">
                                <button type="submit" name="login" 
                                    class="bg-indigo-600 text-white active:bg-indigo-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full transition-all duration-150 hover:bg-indigo-700">
                                    Sign In
                                </button>
                            </div>
                        </form>
                        <div class="mt-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span class="text-gray-600">Don't have an account?</span>
                                <a href="register.php" 
                                   class="text-indigo-600 font-semibold hover:text-indigo-800 transition-colors duration-200">
                                    Register here
                                </a>
                            </div>
                            <a href="index.php" 
                               class="text-gray-500 hover:text-gray-700 text-sm mt-3 inline-block transition-colors duration-200">
                                ← Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
