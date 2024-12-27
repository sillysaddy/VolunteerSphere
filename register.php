<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registration</h2>
        <form method="post" action="register.php">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="qualifications" class="form-label">Qualifications:</label>
                <input type="text" id="qualifications" name="qualifications" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

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

        $sql = "INSERT INTO volunteers (Name, Email, Phone, Qualifications, Password, Approved) VALUES ('$name', '$email', '$phone', '$qualifications', '$password', 0)";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Waiting for approval');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>