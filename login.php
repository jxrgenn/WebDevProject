<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $username1 = $_POST["username"];
    $password1 = $_POST["password"];

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

    // Prepare the SQL statement to retrieve the user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username1);

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if a user with the given username exists
    if ($result->num_rows === 1) {
       
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify the password
        if (password_verify($password1, $storedPassword)) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: landingPage.html");       
         } else {
            echo "Invalid password";
        }
    } else {
        echo "This user does not exist";
    }

    // Close the result set, prepared statement, and database connection
    $result->close();
    $stmt->close();
    $conn->close();
}
?>
