<?php
include('db.php');
session_start();

// Ensure the user is logged in as an organization
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'organization') {
    header("Location: login.php");
    exit();
}

// Fetch all volunteers and their hire statuses
$volunteerQuery = "
    SELECT v.*, 
           (SELECT COUNT(*) 
            FROM hires h 
            WHERE h.VolunteerID = v.VolunteerID AND h.OrgID = {$_SESSION['user_id']}
           ) AS HiredStatus
    FROM volunteers v
";
$volunteerResult = $conn->query($volunteerQuery);

// Fetch event applications
$eventApplicationsQuery = "
    SELECT a.ApplicationID, v.Name AS VolunteerName, e.EventName, a.Status
    FROM applications a
    JOIN volunteers v ON a.VolunteerID = v.VolunteerID
    JOIN events e ON a.EventID = e.EventID
    WHERE e.OrgID = {$_SESSION['user_id']}
";
$eventApplicationsResult = $conn->query($eventApplicationsQuery);

// Fetch emergency requests
$emergencyRequestsQuery = "
    SELECT ar.RequestID, v.Name AS VolunteerName, ea.SupportTool, ar.Status
    FROM assistance_requests ar
    JOIN volunteers v ON ar.VolunteerID = v.VolunteerID
    JOIN emergencyassistance ea ON ar.AssistanceID = ea.AssistanceID
    WHERE ea.OrgID = {$_SESSION['user_id']}
";
$emergencyRequestsResult = $conn->query($emergencyRequestsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">VolunteerSphere</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="logout.php" class="text-gray-600 hover:text-indigo-600 font-medium">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
            <div class="flex space-x-4">
                <button onclick="showSection('volunteersSection')" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">Volunteers</button>
                <button onclick="showSection('eventApplicationsSection')" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Event Applications</button>
                <button onclick="showSection('emergencyRequestsSection')" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors">Emergency Requests</button>
            </div>
        </div>

        <!-- Volunteers Section -->
        <div id="volunteersSection" class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Volunteers</h2>
            <form method="POST" action="hire_multiple_volunteers.php">
                <?php if ($volunteerResult->num_rows > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php while ($volunteer = $volunteerResult->fetch_assoc()): ?>
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($volunteer['Name']); ?></h3>
                                    <div class="space-y-2 mb-4">
                                        <p class="text-gray-600"><span class="font-medium">Email:</span> <?php echo htmlspecialchars($volunteer['Email']); ?></p>
                                        <p class="text-gray-600"><span class="font-medium">Phone:</span> <?php echo htmlspecialchars($volunteer['Phone']); ?></p>
                                        <p class="text-gray-600"><span class="font-medium">Qualifications:</span> <?php echo htmlspecialchars($volunteer['Qualifications']); ?></p>
                                        <p class="text-gray-600">
                                            <span class="font-medium">Emergency Help:</span>
                                            <span class="<?php echo ($volunteer['EmergencyHelp'] == 1) ? 'text-green-600' : 'text-red-600'; ?>">
                                                <?php echo ($volunteer['EmergencyHelp'] == 1) ? 'Available' : 'Not Available'; ?>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="space-y-3">
                                        <?php if ($volunteer['HiredStatus'] > 0): ?>
                                            <button disabled class="w-full px-4 py-2 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">Already Hired</button>
                                        <?php else: ?>
                                            <a href="hire_volunteer.php?VolunteerID=<?php echo $volunteer['VolunteerID']; ?>" 
                                               class="block w-full px-4 py-2 bg-green-600 text-white text-center rounded-md hover:bg-green-700 transition-colors">
                                                Hire
                                            </a>
                                            <div class="flex space-x-2">
                                                <a href="offer_certificate.php?VolunteerID=<?php echo $volunteer['VolunteerID']; ?>" 
                                                   class="flex-1 px-4 py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition-colors">
                                                    Certificate
                                                </a>
                                                <a href="offer_internship.php?VolunteerID=<?php echo $volunteer['VolunteerID']; ?>" 
                                                   class="flex-1 px-4 py-2 bg-yellow-500 text-white text-center rounded-md hover:bg-yellow-600 transition-colors">
                                                    Internship
                                                </a>
                                            </div>
                                            <div class="flex items-center space-x-2 mt-2">
                                                <input type="checkbox" 
                                                       name="selected_volunteers[]" 
                                                       value="<?php echo $volunteer['VolunteerID']; ?>" 
                                                       id="volunteer_<?php echo $volunteer['VolunteerID']; ?>"
                                                       class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label for="volunteer_<?php echo $volunteer['VolunteerID']; ?>" class="text-sm text-gray-600">
                                                    Select for Multiple Hire
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="mt-6">
                        <button type="submit" name="hire_multiple" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                            Hire Selected Volunteers
                        </button>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No volunteers are currently available.</p>
                <?php endif; ?>
            </form>
        </div>

        <!-- Event Applications Section -->
        <div id="eventApplicationsSection" class="hidden bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Event Applications</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volunteer Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($application = $eventApplicationsResult->fetch_assoc()): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($application['VolunteerName']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($application['EventName']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($application['Status']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <?php if ($application['Status'] === 'Pending'): ?>
                                        <div class="flex space-x-2">
                                            <a href="approve_application.php?id=<?php echo $application['ApplicationID']; ?>&action=approve" 
                                               class="text-green-600 hover:text-green-900">Approve</a>
                                            <a href="approve_application.php?id=<?php echo $application['ApplicationID']; ?>&action=reject" 
                                               class="text-red-600 hover:text-red-900">Reject</a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500"><?php echo $application['Status']; ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Emergency Requests Section -->
        <div id="emergencyRequestsSection" class="hidden bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Emergency Requests</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volunteer Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Support Tool</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($request = $emergencyRequestsResult->fetch_assoc()): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($request['VolunteerName']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($request['SupportTool']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars($request['Status']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <?php if ($request['Status'] === 'Pending'): ?>
                                        <div class="flex space-x-2">
                                            <a href="approve_request.php?id=<?php echo $request['RequestID']; ?>&action=approve" 
                                               class="text-green-600 hover:text-green-900">Approve</a>
                                            <a href="approve_request.php?id=<?php echo $request['RequestID']; ?>&action=reject" 
                                               class="text-red-600 hover:text-red-900">Reject</a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500"><?php echo $request['Status']; ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.getElementById('volunteersSection').classList.add('hidden');
            document.getElementById('eventApplicationsSection').classList.add('hidden');
            document.getElementById('emergencyRequestsSection').classList.add('hidden');
            
            document.getElementById(sectionId).classList.remove('hidden');
        }
    </script>
</body>
</html>
