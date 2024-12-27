<?php
include('db.php');


// Fetch All Volunteers
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT * FROM Volunteers");
    $stmt->execute();
    $volunteers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($volunteers);
}

// Add a New Volunteer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO Volunteers (UserID, Qualifications) VALUES (:user_id, :qualifications)");
    $stmt->bindParam(':user_id', $data['user_id']);
    $stmt->bindParam(':qualifications', $data['qualifications']);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Volunteer added successfully']);
    } else {
        echo json_encode(['message' => 'Error adding volunteer']);
    }
}
?>
