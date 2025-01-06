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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center">
                        <span class="text-2xl font-bold text-indigo-600">VolunteerSphere</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="login.php" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="register.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Register</a>
                    <?php else: ?>
                        <a href="logout.php" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Make a difference with</span>
                            <span class="block text-indigo-600">VolunteerSphere</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Connect with organizations, join meaningful projects, and create positive change in your community.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <?php if (!isset($_SESSION['user'])): ?>
                                <div class="rounded-md shadow">
                                    <a href="login.php" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                        Get Started
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Features</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Everything you need to make an impact
                </p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                    <!-- Find Opportunities -->
                    <div class="relative">
                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Find Opportunities</h3>
                                <p class="text-gray-500 mb-4">Match with organizations based on your skills and interests.</p>
                                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'volunteer'): ?>
                                    <a href="volunteer_dashboard.php?skill_search=1" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Skill-Based Search
                                    </a>
                                <?php else: ?>
                                    <p class="text-sm text-gray-400">Login as a volunteer to use this feature</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Help -->
                    <div class="relative">
                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Emergency Help</h3>
                                <p class="text-gray-500 mb-4">Get immediate help and tools from organizations.</p>
                                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'volunteer'): ?>
                                    <a href="volunteer_dashboard.php?emergency_help=1" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600">
                                        Request Help
                                    </a>
                                <?php else: ?>
                                    <p class="text-sm text-gray-400">Login as a volunteer to use this feature</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Join Events -->
                    <div class="relative">
                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition duration-300">
                            <div class="text-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Join Events</h3>
                                <p class="text-gray-500 mb-4">Browse and apply for events organized by NGOs and groups.</p>
                                <?php if (isset($_SESSION['user']) && $_SESSION['role'] === 'volunteer'): ?>
                                    <a href="volunteer_dashboard.php" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                        View Events
                                    </a>
                                <?php else: ?>
                                    <p class="text-sm text-gray-400">Login to browse events</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-base text-gray-400">&copy; 2024 VolunteerSphere. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
