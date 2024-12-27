<!DOCTYPE html>
<html>
<head>
    <title>Volunteer Registration</title>
</head>
<body>
    <h2>Volunteer Registration</h2>
    <form method="post" action="volunteer_register.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br><br>
        <label for="qualifications">Qualifications:</label>
        <input type="text" id="qualifications" name="qualifications" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "volunteerhiredb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $qualifications = $_POST['qualifications'];
    $password = $_POST['password'];

    $sql = "INSERT INTO volunteers (Name, Email, Phone, Qualifications, Password) VALUES ('$name', '$email', '$phone', '$qualifications', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Volunteer registered successfully. Awaiting admin approval.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>