<?php
include 'db.php'; // Include the database connection file
session_start();

// Handle the form submission for creating a room
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomName = $_POST['room-name'];

    // Check if the room already exists in the database
    $checkRoomQuery = "SELECT * FROM Rooms WHERE RoomName = ?";
    $stmt = $conn->prepare($checkRoomQuery);
    $stmt->bind_param("s", $roomName);
    $stmt->execute();
    $roomResult = $stmt->get_result();

    if ($roomResult->num_rows > 0) {
        echo "Room already exists!";
    } else {
        // Insert the new room into the database
        $insertRoomQuery = "INSERT INTO Rooms (RoomName) VALUES (?)";
        $stmt = $conn->prepare($insertRoomQuery);
        $stmt->bind_param("s", $roomName);
        if ($stmt->execute()) {
            echo "Room '$roomName' created successfully!";
            // Redirect to the room listing or video call page
            header("Location: join-room.php");
        } else {
            echo "Error creating room.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
    <link rel="icon" href="circular_logo_full.png" type="png">
    <link rel="stylesheet" href="create.css">
</head>
<style>
    /* General styles remain unchanged */
/* General styles */
html, body {
    height: 100%; /* Ensure the body takes the full height of the viewport */
    margin: 0; /* Remove default margin */
}

body {
    display: flex;                 
    flex-direction: column;         
    min-height: 100vh;             
    background-image: url('studyparkbg.gif');
    background-size: cover;         
    background-position: center;    
    font-family: 'Roboto', sans-serif;
    font-weight: bold;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    width: 90%; /* Use 90% width for smaller devices */
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin: auto; /* Center the container horizontally */
    background-color: rgba(255, 255, 255, 0.8);
}

footer {   
    background-color: #ce9883; 
    color: rgb(0, 0, 0);
    text-align: center; 
    padding: 5px; 
    font-weight: bold;
}

/* Form styles */
h1 {
    font-size: 2em;
    text-align: center;
    margin-bottom: 20px;
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
            background-color: #ce9883; /* Same color as the nav bar */
            color: white;               /* Text color should be white */
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            font-weight: bolder;        /* Make the font bolder */
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #a57462;  /* Darker shade of the nav bar color on hover */
        }

/* Navigation Styles */
nav {
    background-color: Transparent;
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
    background-color: white;
}

@media (max-width: 768px) {
    nav {
        flex-direction: column;
        align-items: flex-start;
    }

    nav ul {
        flex-direction: column;
    }
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
        <h1>Create a Room</h1>
        <form id="create-room-form" method="POST">
            <label for="room-name">Room Name:</label>
            <input type="text" id="room-name" name="room-name" placeholder="Enter Room Name" required>
            <button type="submit">Create Room</button>
        </form>
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