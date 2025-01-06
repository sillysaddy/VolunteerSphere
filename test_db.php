<?php
include('db.php');

if ($conn->ping()) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed: " . $conn->error;
}
?>
