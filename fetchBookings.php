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

session_start();
$user_id = $_SESSION['user_id'];

// Prepare the SQL statement to fetch the user's bookings
$stmt = $conn->prepare("SELECT * FROM booking WHERE user_id = ?");
$stmt->bind_param("i", $user_id);

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Check if any bookings are found
if ($result->num_rows > 0) {
    // Start building the HTML representation of the bookings
    $html = "<h2>My Bookings</h2>";
    $html .= "<ul>";

    // Loop through the bookings and add them to the HTML
    while ($row = $result->fetch_assoc()) {
        $roomNumber = $row['roomNumber'];
        $checkInDate = $row['checkInDate'];
        $checkOutDate = $row['checkOutDate'];

        $html .= "<li>Room: $roomNumber | Check-in: $checkInDate | Check-out: $checkOutDate</li>";
    }

    $html .= "</ul>";
} else {
    // No bookings found
    $html = "<p>No bookings found.</p>";
}

// Close the result set and prepared statement
$result->close();
$stmt->close();

// Close the database connection
$conn->close();

// Return the HTML representation of the bookings
echo $html;
?>
