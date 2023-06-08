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

// Prepare the SQL statement to retrieve the users with role 'client'
$stmt = $conn->prepare("SELECT first_name, last_name, username, email, role FROM users WHERE role = 'client'");

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Check if any users are found
if ($result->num_rows > 0) {
    // Iterate over the users and generate the HTML table rows
    while ($row = $result->fetch_assoc()) {
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];
        $username = $row['username'];
        $email = $row['email'];
        $role = $row['role'];

        echo "<tr>";
        echo "<td>$firstname</td>";
        echo "<td>$lastname</td>";
        echo "<td>$username</td>";
        echo "<td>$email</td>";
        echo "<td>$role</td>";
        echo "<td><button onclick='promoteUser(\"$username\")'>Promote</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No users found.</td></tr>";
}

// Close the result set and prepared statement
$result->close();
$stmt->close();

// Close the database connection
$conn->close();
?>
