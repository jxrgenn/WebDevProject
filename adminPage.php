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

// Retrieve the check-in and check-out dates from the GET parameters
$checkInDate = $_GET['checkInDate'];
$checkOutDate = $_GET['checkOutDate'];

// Prepare the SQL statement to retrieve the reserved rooms
$stmt = $conn->prepare("SELECT roomNumber, bookingId, checkInDate, checkOutDate FROM booking WHERE checkInDate <= ? AND checkOutDate >= ?");
$stmt->bind_param("ss", $checkOutDate, $checkInDate);

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Check if any rooms are reserved during the selected dates
if ($result->num_rows > 0) {
    // Iterate over the available rooms
    while ($row = $result->fetch_assoc()) {
        $roomNumber = $row['roomNumber'];
        $bookingId = $row['bookingId'];
        
        // Display the room block with image, room number, price, and "Book Now" button
        echo "<div class='room-block'>";
        echo "<div class='room-details'>";
        echo "<div class='room-number'>Room number $roomNumber</div>";
        echo "<div class='booking-id'>Booking Id: $bookingId</div>";
        echo "<div class='check-in-date'>Check-In Date: $checkInDate</div>";
        echo "<div class='check-out-date'>Check-Out Date: $checkOutDate</div>";
        echo "</div>";
        echo "</div>";
    }
}

// Close the result set, prepared statement, and database connection
$result->close();
$stmt->close();
$conn->close();
?>
