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
    <title>Organization Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function showSection(sectionId) {
            document.getElementById('volunteersSection').style.display = 'none';
            document.getElementById('eventApplicationsSection').style.display = 'none';
            document.getElementById('emergencyRequestsSection').style.display = 'none';

            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1>
            Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!
            <div class="float-end">
                <button class="btn btn-primary" onclick="showSection('eventApplicationsSection')">Event Applications</button>
                <button class="btn btn-warning" onclick="showSection('emergencyRequestsSection')">Emergency Requests</button>
            </div>
        </h1>

        <!-- List of Volunteers -->
        <div id="volunteersSection">
            <h2 class="mt-4">List of Volunteers</h2>
            <form method="POST" action="hire_multiple_volunteers.php">
                <?php if ($volunteerResult->num_rows > 0): ?>
                    <div class="row">
                        <?php while ($volunteer = $volunteerResult->fetch_assoc()): ?>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="<?php echo $volunteer['Picture'] ? $volunteer['Picture'] : ($volunteer['Gender'] === 'Male' ? 'images/male_silhouette.png' : 'images/female_silhouette.png'); ?>" 
                                         class="card-img-top" alt="Volunteer Picture" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($volunteer['Name']); ?></h5>
                                        <p class="card-text">Email: <?php echo htmlspecialchars($volunteer['Email']); ?></p>
                                        <p class="card-text">Phone: <?php echo htmlspecialchars($volunteer['Phone']); ?></p>
                                        <p class="card-text">Qualifications: <?php echo htmlspecialchars($volunteer['Qualifications']); ?></p>
                                        <p class="card-text">Available for Emergency: <?php echo ($volunteer['EmergencyHelp'] == 1) ? 'Yes' : 'No'; ?></p>

                                        <?php if ($volunteer['HiredStatus'] > 0): ?>
                                            <button class="btn btn-secondary" disabled>Hired</button>
                                        <?php else: ?>
                                            <a href="hire_volunteer.php?VolunteerID=<?php echo $volunteer['VolunteerID']; ?>" class="btn btn-success mb-2">Hire</a>
                                            <a href="offer_certificate.php?VolunteerID=<?php echo $volunteer['VolunteerID']; ?>" class="btn btn-info mb-2">Offer Certificate</a>
                                            <a href="offer_internship.php?VolunteerID=<?php echo $volunteer['VolunteerID']; ?>" class="btn btn-warning mb-2">Offer Internship</a>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="selected_volunteers[]" value="<?php echo $volunteer['VolunteerID']; ?>" id="volunteer_<?php echo $volunteer['VolunteerID']; ?>">
                                                <label class="form-check-label" for="volunteer_<?php echo $volunteer['VolunteerID']; ?>">
                                                    Select for Multiple Hire
                                                </label>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <button type="submit" name="hire_multiple" class="btn btn-primary">Hire Selected Volunteers</button>
                <?php else: ?>
                    <p>No volunteers are currently available.</p>
                <?php endif; ?>
            </form>
        </div>

        <!-- Event Applications -->
        <div id="eventApplicationsSection" style="display: none;">
            <h2 class="mt-4">Event Applications</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Volunteer Name</th>
                        <th>Event Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($application = $eventApplicationsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($application['VolunteerName']); ?></td>
                            <td><?php echo htmlspecialchars($application['EventName']); ?></td>
                            <td><?php echo htmlspecialchars($application['Status']); ?></td>
                            <td>
                                <?php if ($application['Status'] === 'Pending'): ?>
                                    <a href="approve_application.php?id=<?php echo $application['ApplicationID']; ?>&action=approve" class="btn btn-success btn-sm">Approve</a>
                                    <a href="approve_application.php?id=<?php echo $application['ApplicationID']; ?>&action=reject" class="btn btn-danger btn-sm">Reject</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled><?php echo $application['Status']; ?></button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Emergency Requests -->
        <div id="emergencyRequestsSection" style="display: none;">
            <h2 class="mt-4">Emergency Requests</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Volunteer Name</th>
                        <th>Support Tool</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($request = $emergencyRequestsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($request['VolunteerName']); ?></td>
                            <td><?php echo htmlspecialchars($request['SupportTool']); ?></td>
                            <td><?php echo htmlspecialchars($request['Status']); ?></td>
                            <td>
                                <?php if ($request['Status'] === 'Pending'): ?>
                                    <a href="approve_request.php?id=<?php echo $request['RequestID']; ?>&action=approve" class="btn btn-success btn-sm">Approve</a>
                                    <a href="approve_request.php?id=<?php echo $request['RequestID']; ?>&action=reject" class="btn btn-danger btn-sm">Reject</a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled><?php echo $request['Status']; ?></button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>
</html>






