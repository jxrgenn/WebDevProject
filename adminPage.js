// Function to show the user list
function showUsers() {
    var request = new XMLHttpRequest();
    request.open('GET', 'getUsers.php', true);
    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        var response = request.responseText;
        var table = document.getElementById('userTable');
        table.innerHTML = response;
      } else {
        console.error('An error occurred while retrieving the user list.');
      }
    };
    request.onerror = function() {
      console.error('An error occurred while retrieving the user list.');
    };
    request.send();
  }
  
  // Function to promote a user to admin
  function promoteUser(username) {
    var request = new XMLHttpRequest();
    request.open('POST', 'promoteUser.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        var response = request.responseText;
        if (response === 'success') {
          var table = document.getElementById('userTable');
          var rows = table.getElementsByTagName('tr');
          for (var i = 1; i < rows.length; i++) {
            var row = rows[i];
            if (row.cells[2].textContent === username) {
              row.cells[4].textContent = 'admin';
              row.cells[5].innerHTML = '';
              break;
            }
          }
          alert('User promoted to admin successfully.');
        } else {
          alert('Failed to promote the user to admin.');
        }
      } else {
        alert('An error occurred while promoting the user to admin.');
      }
    };
    request.onerror = function() {
      alert('An error occurred while promoting the user to admin.');
    };
    request.send('username=' + encodeURIComponent(username));
  }
  
function showReservedRooms() {
    // Get the selected check-in and check-out dates
    const checkInDate = document.getElementById('checkInDate').value;
    const checkOutDate = document.getElementById('checkOutDate').value;
  
    // Send an AJAX request to the server to fetch reserved rooms
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `adminPage.php?checkInDate=${checkInDate}&checkOutDate=${checkOutDate}`, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Display the reserved rooms in the reservedRooms div
        document.getElementById('reserve-rooms').innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  }
  
  
  
  
  // Function to fetch and display the user list
  function fetchUserList() {
    // Make an AJAX request to fetch the user list
    $.ajax({
      url: "fetchUserList.php",
      type: "GET",
      success: function(response) {
        // Display the user list in the userList ul
        $("#userList").html(response);
      }
    });
  }
  