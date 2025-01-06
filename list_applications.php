<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Pagination settings
$limit = 10; // Rows per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total rows
$totalRowsQuery = "SELECT COUNT(*) as total FROM applications";
$totalRowsResult = $conn->query($totalRowsQuery);
$totalRows = $totalRowsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch paginated applications
$query = "
    SELECT v.Name AS VolunteerName, e.EventName, o.Name AS OrgName
    FROM applications a
    JOIN volunteers v ON a.VolunteerID = v.VolunteerID
    JOIN events e ON a.EventID = e.EventID
    JOIN organizations o ON e.OrgID = o.OrgID
    LIMIT $limit OFFSET $offset;
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications Submitted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Applications Submitted</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Volunteer Name</th>
                    <th>Event Name</th>
                    <th>Organization Name</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['VolunteerName']); ?></td>
                        <td><?php echo htmlspecialchars($row['EventName']); ?></td>
                        <td><?php echo htmlspecialchars($row['OrgName']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>

