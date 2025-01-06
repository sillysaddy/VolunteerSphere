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
    <title>Volunteer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .points-feature {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Welcome Section -->
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
        <p class="text-muted">Explore organizations, events, and emergency help below:</p>

        <!-- Points Feature -->
        <div class="points-feature" title="Claim Reward">
            <img src="images/coin.png" alt="Points" style="width: 40px; height: 40px;">
            <span><?php echo $currentPoints; ?> Points</span>
        </div>

        <!-- Navigation Buttons -->
        <div class="mb-4">
            <a href="volunteer_dashboard.php?skill_search=1" class="btn btn-primary btn-lg me-2">Skill-Based Search</a>
            <a href="volunteer_dashboard.php?emergency_help=1" class="btn btn-warning btn-lg me-2">Emergency Help</a>
            <a href="rewards.php" class="btn btn-success btn-lg">Claim Reward</a>
            <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
        </div>

        <!-- Skill-Based Search Section -->
        <?php if (isset($_GET['skill_search']) && $_GET['skill_search'] == '1'): ?>
            <h2 class="mt-4">Organizations Matching Your Skills</h2>
            <form method="GET" class="mb-4">
                <input type="hidden" name="skill_search" value="1">
                <input type="text" name="search_skill" class="form-control" placeholder="Type your skill to search for matching organizations" value="<?php echo htmlspecialchars($searchSkill); ?>">
                <button type="submit" class="btn btn-primary mt-2">Search</button>
            </form>
            <?php if (!empty($skillSearchResults)): ?>
                <div class="row">
                    <?php foreach ($skillSearchResults as $org): ?>
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="<?php echo $org['Picture'] ? $org['Picture'] : 'images/default_org.png'; ?>" 
                                             class="img-fluid rounded-start" 
                                             alt="<?php echo htmlspecialchars($org['Name']); ?>" 
                                             style="height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($org['Name']); ?></h5>
                                            <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($org['Type']); ?></p>
                                            <p class="card-text"><strong>Specialities:</strong> <?php echo htmlspecialchars($org['Specialities']); ?></p>
                                            <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($org['Address']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No matching organizations found.</p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Emergency Assistance Section -->
        <?php if (isset($_GET['emergency_help']) && $_GET['emergency_help'] == '1'): ?>
            <h2 class="mt-4">Available Emergency Assistance</h2>
            <?php if ($emergencyResult->num_rows > 0): ?>
                <div class="row">
                    <?php while ($row = $emergencyResult->fetch_assoc()): ?>
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['OrgName']); ?></h5>
                                    <p class="card-text"><strong>Assistance Tool:</strong> <?php echo htmlspecialchars($row['SupportTool']); ?></p>
                                    <a href="request_emergency.php?AssistanceID=<?php echo $row['AssistanceID']; ?>" class="btn btn-primary">Request Assistance</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No emergency assistance is available at the moment.</p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Organizations and Events Section -->
        <h2 class="mt-4">Organizations and Events</h2>
        <div class="row">
            <?php 
            $currentOrgID = null;
            while ($row = $orgResult->fetch_assoc()): 
            ?>
                <?php if ($currentOrgID !== $row['OrgID']): ?>
                    <?php if ($currentOrgID !== null): ?>
                        </ul>
                        </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="<?php echo $row['OrgPicture'] ? $row['OrgPicture'] : 'images/default_org.png'; ?>" 
                                         class="img-fluid rounded-start" 
                                         alt="<?php echo htmlspecialchars($row['OrgName']); ?>" 
                                         style="height: 200px; object-fit: cover;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['OrgName']); ?></h5>
                                        <p class="card-text"><strong>Type:</strong> <?php echo htmlspecialchars($row['Type']); ?></p>
                                        <p class="card-text"><strong>Specialities:</strong> <?php echo htmlspecialchars($row['Specialities']); ?></p>
                                        <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($row['Address']); ?></p>
                                        <h6>Events:</h6>
                                        <ul class="list-group list-group-flush">
                <?php endif; ?>
                <?php if ($row['EventID']): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($row['EventName']); ?></strong>
                        <p class="mb-0"><?php echo htmlspecialchars($row['Description']); ?></p>
                        <small class="text-muted">Date: <?php echo htmlspecialchars($row['Date']); ?></small>
                        <?php if ($row['AppliedStatus'] > 0): ?>
                            <button class="btn btn-secondary mt-2" disabled>Applied</button>
                        <?php else: ?>
                            <a href="submit_application.php?EventID=<?php echo $row['EventID']; ?>" class="btn btn-sm btn-primary mt-2">Apply for Event</a>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
                <?php $currentOrgID = $row['OrgID']; ?>
            <?php endwhile; ?>
            </ul>
            </div>
            </div>
        </div>
    </div>
</body>
</html>

























