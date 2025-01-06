<?php
include('db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_SESSION['role']; // Role: 'volunteer' or 'organization'
    $userID = $_SESSION['user_id']; // User ID of the logged-in user
    $uploadDir = "images/";
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    // Check if a file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileType = $_FILES['image']['type'];

        // Check if the file type is allowed
        if (in_array($fileType, $allowedTypes)) {
            // Generate a unique file name to prevent overwriting
            $fileName = $role . '_' . $userID . '_' . time() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $destPath = $uploadDir . $fileName;

            // Move the file to the images directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Update the database with the image path
                if ($role === 'volunteer') {
                    $updateQuery = "UPDATE volunteers SET Picture = '$destPath' WHERE VolunteerID = $userID";
                } elseif ($role === 'organization') {
                    $updateQuery = "UPDATE organizations SET Picture = '$destPath' WHERE OrgID = $userID";
                }

                if ($conn->query($updateQuery)) {
                    echo "<script>alert('Image uploaded successfully!'); window.location.href='dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error updating the database. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('Error moving the uploaded file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Please upload a JPG or PNG image.');</script>";
        }
    } else {
        echo "<script>alert('No file uploaded or an error occurred.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Upload Your Image</h1>
        <form action="upload_image.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Choose Image (JPG or PNG)</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
