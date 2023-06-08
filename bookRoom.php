<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
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

    // Retrieve the room number, check-in date, and check-out date from the POST data
    $roomNumber = $_POST['roomNumber'];
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];

    // Retrieve the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement to insert the booking record
    $stmt = $conn->prepare("INSERT INTO booking (roomNumber, checkInDate, checkOutDate, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $roomNumber, $checkInDate, $checkOutDate, $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Booking successful
        echo "Room booked successfully";
    } else {
        // Booking failed
        echo "Error booking room";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // User is not logged in, handle the error or redirect to the login page
    echo "User is not logged in";
    // You can also redirect to the login page using the following code:
    // header("Location: login.php");
    // exit();
}
?>
