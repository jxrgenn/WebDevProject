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

// Retrieve the check-in and check-out dates from the form
$checkInDate = $_GET['checkInDate'];
$checkOutDate = $_GET['checkOutDate'];

// Prepare the SQL statement to check room availability
$stmt = $conn->prepare("SELECT roomprice, roomNumber, roomPhoto FROM room WHERE roomNumber NOT IN (SELECT roomNumber FROM booking WHERE checkOutDate > ? AND checkInDate < ?)");
$stmt->bind_param("ss", $checkInDate, $checkOutDate);


// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Check if there are available rooms
// Check if there are available rooms
if ($result->num_rows > 0) {
    // Iterate over the available rooms
    while ($row = $result->fetch_assoc()) {
        $roomNumber = $row['roomNumber'];
        $roomPrice = $row['roomprice'];
        $roomPhoto = $row['roomPhoto'];
        
        // Display the room block with image, room number, price, and "Book Now" button
        echo "<div class='room-block'>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($roomPhoto) . "' class='room-image'>";
        echo "<div class='room-details'>";
        echo "<div class='room-number'>Room number $roomNumber</div>";
        echo "<div class='room-price'>Price: $roomPrice</div>";
        echo '<button class="book-now-button" data-room-number="' . $roomNumber . '">Book Now</button>';
        echo "</div>";
        echo "</div>";
    }
}



// Close the statement and database connection
$stmt->close();
$conn->close();
?>
