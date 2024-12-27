<?php
include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $org_id = $_GET['id'];
    $query = "SELECT * FROM organizations WHERE OrgID = '$org_id'";
    $result = $conn->query($query);
    $organization = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $org_id = $_POST['org_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $address = $_POST['address'];

    $query = "UPDATE organizations SET Name = '$name', Email = '$email', Type = '$type', Address = '$address' WHERE OrgID = '$org_id'";
    if ($conn->query($query)) {
        echo "<script>alert('Organization updated successfully!'); window.location.href = 'list_organizations.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Organization</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Organization</h1>
        <form action="edit_organization.php" method="POST">
            <input type="hidden" name="org_id" value="<?php echo $organization['OrgID']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $organization['Name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $organization['Email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="<?php echo $organization['Type']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $organization['Address']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Update Organization</button>
        </form>
    </div>
</body>
</html>
