function showAvailableRooms() {
    // Get the selected check-in and check-out dates
    const checkInDate = document.getElementById('checkInDate').value;
    const checkOutDate = document.getElementById('checkOutDate').value;
  
    // Send an AJAX request to the server to fetch available rooms
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `landingPage.php?checkInDate=${checkInDate}&checkOutDate=${checkOutDate}`, true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        // Display the available rooms in the availableRooms div
        document.getElementById('availableRooms').innerHTML = xhr.responseText;
  
        // Add event listeners to the "Book Now" buttons
        const bookButtons = document.getElementsByClassName('book-now-button');
        Array.from(bookButtons).forEach(button => {
          const roomNumber = button.dataset.roomNumber;
  
          button.addEventListener('click', function() {
            console.log('Clicked roomNumber:', roomNumber);
            // Call the bookRoom function with the room number
            bookRoom(roomNumber, checkInDate, checkOutDate);
          });
        });
      }
    };
    xhr.send();
  }
  
  function bookRoom(roomNumber, checkInDate, checkOutDate) {
    // Show confirmation dialog
    const confirmation = prompt(`Are you sure you want to book room ${roomNumber}? Type 'confirm' to proceed.`);
  
    if (confirmation === 'confirm') {
      // Make the AJAX request to book the room
      const bookXHR = new XMLHttpRequest();
      bookXHR.open('POST', 'bookRoom.php', true);
      bookXHR.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      bookXHR.onload = function() {
        if (bookXHR.status === 200) {
          // Handle the response from the bookRoom.php file
          const response = bookXHR.responseText;
          alert(response); // Display a success or error message
        }
      };
      bookXHR.send(`roomNumber=${roomNumber}&checkInDate=${checkInDate}&checkOutDate=${checkOutDate}`);
    }
  }
  