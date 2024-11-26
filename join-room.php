<?php
include 'db.php'; // Include the database connection file
session_start();

// Initialize error message
$errorMessage = '';

// Fetch rooms from the database
$query = "SELECT * FROM Rooms";
$result = $conn->query($query);

// Handle the form submission for joining a room
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['room-name']) && !empty($_POST['room-name'])) {
        $roomName = $_POST['room-name'];

        // Case-insensitive and trimmed room name check
        $checkRoomQuery = "SELECT * FROM Rooms WHERE TRIM(LOWER(RoomName)) = LOWER(?)";
        $stmt = $conn->prepare($checkRoomQuery);
        $stmt->bind_param("s", $roomName);
        $stmt->execute();
        $roomResult = $stmt->get_result();

        if ($roomResult->num_rows > 0) {
            // Redirect to the video call page
            header("Location: try.php?room=" . urlencode($roomName));
            exit; // Ensure no further code is executed after redirection
        } else {
            // Set error message for non-existent room
            $errorMessage = "Sorry, the room '$roomName' does not exist!";
        }
    } else {
        // Handle case where room name is empty
        $errorMessage = "Please enter a room name!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Room</title>
    <link rel="icon" href="circular_logo_full.png" type="png">
</head>
<style> 
   body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            background-image: url('studyparkbg.gif');
            background-size: cover;        
            background-position: center;   
            margin: 0;
            padding: 0; 
            
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.8);
        }   
        h1 {
            font-size: 2em;
            text-align: center;
        }
        label {
            font-size: 1.2em;
            display: block;
            margin: 15px 0 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #ce9883;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
        }
        button:hover {
            background-color: #a57462;
        }
        .room-list {
            margin-top: 30px;
        }
        .room-list ul {
            list-style-type: none;
            padding: 0;
        }
        .room-list li {
            padding: 15px;
            background-color: #e9ecef;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .room-list button {
            background-color: #ce9883;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .room-list button:hover {
            background-color: #a57462;
        }
nav {
    background-color: transparent;
    padding: 10px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

nav img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

nav ul {
    display: flex;
font-weight: bolder;
background-color: transparent;
gap: 1rem;
margin: 0;
padding: 0;
list-style: none;

}

nav ul li {
    position: relative;
}

nav a {
    color: white;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    font-weight: bolder; /* This makes the nav links even bolder */
}

nav a:hover {
    background-color: #a57462;
}

footer {    
    background-color: #ce9883; 
    color: rgb(0, 0, 0);
    text-align: center; 
    padding: 5px; 
    font-weight: bold;
}
</style>
<body>
<nav>
    <!-- Logo on the left -->
    <img src="logo.png" alt="Logo">
    
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="changename.php">Account Settings</a></li>
        <li><a href="login.php">Logout</a></li>
    </ul>
</nav>

    <div class="container">
        <h1>Join a Room</h1>
        <?php
        // Display the error message if there is one
        if ($errorMessage) {
            echo "<div class='error-message'>$errorMessage</div>";
        }
        ?>

        <form id="join-room-form" method="POST">
            <label for="room-name">Room Name:</label>
            <input type="text" id="room-name" name="room-name" placeholder="Enter Room Name" required>
            <button type="submit">Join Room</button>
        </form>

        <div class="room-list">
            <h2>Available Rooms</h2>
            <ul id="room-list">
                <?php
                if ($result->num_rows > 0) {
                    // Display available rooms from the database
                    while ($room = $result->fetch_assoc()) {
                        echo "<li>" . $room['RoomName'] . " 
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='room-name' value='" . $room['RoomName'] . "'>
                                    <button type='submit'>Join</button>
                                </form>
                              </li>";
                    }
                } else {
                    echo "<li>No rooms available</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.querySelector('.dropdown');
            dropdown.classList.toggle('open');
        }
    </script>

    <footer>
        <p>&copy; 2024 StudyPark. All rights reserved.</p>
    </footer>
</body>
</html>
