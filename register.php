<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $first_name = $_POST["firstName"];
    $last_name = $_POST["lastName"];
    $username1 = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database connection settings
    $servername = "localhost";
    $username = "root";  // Change this if you have a different MySQL username
    $password = "";      // Change this if you have a different MySQL password
    $dbname = "loginsystem";

    // Create a new MySQLi instance and establish the database connection
    $conn = new mysqli('localhost', 'root', '', 'loginsystem');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the user data
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $username1, $email, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";  // You can modify this message or redirect the user to a success page
    } else {
        echo "Error: " . $stmt->error;  // Display an error message if the insertion fails
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>
