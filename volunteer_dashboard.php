<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('db.php');
session_start();

// Ensure the user is logged in as a volunteer
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'volunteer') {
    header("Location: login.php");
    exit();
}

// Fetch the logged-in volunteer's details
$volunteerID = $_SESSION['user_id'];
$volunteerQuery = "SELECT Points FROM volunteers WHERE VolunteerID = $volunteerID";
$volunteerResult = $conn->query($volunteerQuery);
$volunteer = $volunteerResult->fetch_assoc();
$currentPoints = $volunteer['Points'];

// Initialize variables for skill-based search
$skillSearchResults = [];
$searchSkill = "";

// Handle Skill-Based Search
if (isset($_GET['skill_search']) && !empty($_GET['search_skill'])) {
    $searchSkill = trim($_GET['search_skill']); // Get the searched skill from input
    $skillSearchQuery = "SELECT * FROM organizations WHERE Specialities LIKE ?";
    $stmt = $conn->prepare($skillSearchQuery);
    $searchSkillWildcard = '%' . $searchSkill . '%';
    $stmt->bind_param("s", $searchSkillWildcard);
    $stmt->execute();
    $skillSearchResult = $stmt->get_result();
    while ($org = $skillSearchResult->fetch_assoc()) {
        $skillSearchResults[] = $org;
    }
    $stmt->close();
}

// Fetch all organizations and their events (default view)
$orgQuery = "
    SELECT o.OrgID, o.Name AS OrgName, o.Type, o.Address, o.Picture AS OrgPicture, 
           o.Specialities, e.EventID, e.EventName, e.Description, e.Date,
           (SELECT COUNT(*) 
            FROM applications a 
            WHERE a.EventID = e.EventID AND a.VolunteerID = $volunteerID
           ) AS AppliedStatus
    FROM organizations o
    LEFT JOIN events e ON o.OrgID = e.OrgID
    ORDER BY o.OrgID, e.Date;
";
$orgResult = $conn->query($orgQuery);

// Fetch emergency assistance tools
$emergencyQuery = "
    SELECT ea.AssistanceID, o.Name AS OrgName, ea.SupportTool
    FROM emergencyassistance ea
    JOIN organizations o ON ea.OrgID = o.OrgID;
";
$emergencyResult = $conn->query($emergencyQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard - VolunteerSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">VolunteerSphere</span>
                </div>
                <div class="flex items-center">
                    <!-- Points Display -->
                    <div class="bg-indigo-50 rounded-full px-4 py-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z" />
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z" />
                        </svg>
                        <span class="text-indigo-600 font-semibold"><?php echo $currentPoints ?? 0; ?> Points</span>
                    </div>
                    <a href="logout.php" class="ml-4 text-gray-600 hover:text-indigo-600 font-medium">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
            <p class="text-gray-600">Explore organizations, events, and emergency help below</p>
        </div>

        <!-- Navigation Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <a href="volunteer_dashboard.php?skill_search=1" 
               class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                Skill-Based Search
            </a>
            <a href="volunteer_dashboard.php?emergency_help=1" 
               class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600">
                Emergency Help
            </a>
            <a href="rewards.php" 
               class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                Claim Reward
            </a>
        </div>

        <!-- Skill-Based Search Section -->
        <?php if (isset($_GET['skill_search']) && $_GET['skill_search'] == '1'): ?>
            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Organizations Matching Your Skills</h2>
                <form method="GET" class="mb-6">
                    <input type="hidden" name="skill_search" value="1">
                    <div class="flex gap-4">
                        <input type="text" name="search_skill" 
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Type your skill to search for matching organizations" 
                               value="<?php echo htmlspecialchars($searchSkill); ?>">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Search
                        </button>
                    </div>
                </form>

                <?php if (!empty($skillSearchResults)): ?>
                    <div class="space-y-6">
                        <?php foreach ($skillSearchResults as $org): ?>
                            <div class="bg-white border rounded-lg overflow-hidden">
                                <div class="md:flex">
                                    <div class="md:flex-shrink-0">
                                        <img src="<?php echo $org['Picture'] ? $org['Picture'] : 'images/default_org.png'; ?>" 
                                             class="h-48 w-full object-cover md:w-48" 
                                             alt="<?php echo htmlspecialchars($org['Name']); ?>">
                                    </div>
                                    <div class="p-8">
                                        <h3 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($org['Name']); ?></h3>
                                        <p class="mt-2 text-gray-600"><span class="font-medium">Type:</span> <?php echo htmlspecialchars($org['Type']); ?></p>
                                        <p class="mt-2 text-gray-600"><span class="font-medium">Specialities:</span> <?php echo htmlspecialchars($org['Specialities']); ?></p>
                                        <p class="mt-2 text-gray-600"><span class="font-medium">Address:</span> <?php echo htmlspecialchars($org['Address']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No matching organizations found.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Emergency Assistance Section -->
        <?php if (isset($_GET['emergency_help']) && $_GET['emergency_help'] == '1'): ?>
            <div class="bg-white shadow rounded-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Available Emergency Assistance</h2>
                <?php if ($emergencyResult->num_rows > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php while ($row = $emergencyResult->fetch_assoc()): ?>
                            <div class="bg-white border rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($row['OrgName']); ?></h3>
                                <p class="text-gray-600 mb-4"><span class="font-medium">Support Tool:</span> <?php echo htmlspecialchars($row['SupportTool']); ?></p>
                                <a href="request_emergency.php?AssistanceID=<?php echo $row['AssistanceID']; ?>" 
                                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600">
                                    Request Assistance
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600">No emergency assistance is available at the moment.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Organizations and Events Section -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Organizations & Events</h2>
            <div class="grid grid-cols-1 gap-6">
                <?php 
                $currentOrgID = null;
                $organizations = array();
                
                // Group events by organization
                while ($row = $orgResult->fetch_assoc()) {
                    if (!isset($organizations[$row['OrgID']])) {
                        $organizations[$row['OrgID']] = [
                            'info' => [
                                'OrgName' => $row['OrgName'],
                                'Type' => $row['Type'],
                                'Address' => $row['Address'],
                                'Picture' => $row['OrgPicture'],
                                'Specialities' => $row['Specialities']
                            ],
                            'events' => []
                        ];
                    }
                    if ($row['EventID']) {
                        $organizations[$row['OrgID']]['events'][] = [
                            'EventID' => $row['EventID'],
                            'EventName' => $row['EventName'],
                            'Description' => $row['Description'],
                            'Date' => $row['Date'],
                            'AppliedStatus' => $row['AppliedStatus']
                        ];
                    }
                }

                // Display organizations and their events
                foreach ($organizations as $orgID => $org): ?>
                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                        <!-- Organization Info -->
                        <div class="md:flex">
                            <div class="md:flex-shrink-0">
                                <img src="<?php echo $org['info']['Picture'] ? $org['info']['Picture'] : 'images/default_org.png'; ?>" 
                                     class="h-48 w-full object-cover md:w-48" 
                                     alt="<?php echo htmlspecialchars($org['info']['OrgName']); ?>">
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900"><?php echo htmlspecialchars($org['info']['OrgName']); ?></h3>
                                <p class="mt-2 text-gray-600"><span class="font-medium">Type:</span> <?php echo htmlspecialchars($org['info']['Type']); ?></p>
                                <p class="mt-2 text-gray-600"><span class="font-medium">Specialities:</span> <?php echo htmlspecialchars($org['info']['Specialities']); ?></p>
                                <p class="mt-2 text-gray-600"><span class="font-medium">Address:</span> <?php echo htmlspecialchars($org['info']['Address']); ?></p>
                            </div>
                        </div>

                        <!-- Events List -->
                        <?php if (!empty($org['events'])): ?>
                            <div class="border-t border-gray-200">
                                <div class="p-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Available Events</h4>
                                    <div class="space-y-4">
                                        <?php foreach ($org['events'] as $event): ?>
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <h5 class="font-semibold text-gray-900"><?php echo htmlspecialchars($event['EventName']); ?></h5>
                                                <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($event['Description']); ?></p>
                                                <p class="text-sm text-gray-500 mt-1">Date: <?php echo htmlspecialchars($event['Date']); ?></p>
                                                <div class="mt-3">
                                                    <?php if ($event['AppliedStatus'] > 0): ?>
                                                        <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-100 cursor-not-allowed" disabled>Applied</button>
                                                    <?php else: ?>
                                                        <a href="submit_application.php?EventID=<?php echo $event['EventID']; ?>" 
                                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                            Apply for Event
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="p-6 border-t border-gray-200">
                                <p class="text-gray-500">No events available from this organization.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
