<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the username from the POST data
$username = $_POST['username'];

// Prepare the SQL statement to update the user's role
$stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE username = ?");
$stmt->bind_param("s", $username);

// Execute the statement
if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
