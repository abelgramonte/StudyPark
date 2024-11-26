<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection file
include 'db.php'; 

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all rooms, regardless of whether LeaveTime is NULL or not
$fetchRoomsQuery = "SELECT RoomID, RoomName, JoinTime, LeaveTime FROM videocalls"; // Fetch all rooms
$stmt = $conn->prepare($fetchRoomsQuery);

// Check if SQL query preparation failed
if (!$stmt) {
    die("Error preparing SQL query: " . $conn->error);
}

// Execute the query
$stmt->execute();
$roomsResult = $stmt->get_result();
$rooms = [];

if ($roomsResult->num_rows > 0) {
    // Fetch all rooms and store them in an array
    while ($room = $roomsResult->fetch_assoc()) {
        $rooms[] = $room;
    }
} else {
    $rooms = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
    display: flex;
    flex-direction: column; /* Arrange content vertically */
    min-height: 100vh; /* Ensure full-page height */
    background-image: url('studyparkbg.gif'); /* Replace with your image path */
    background-size: cover; /* Cover the entire screen */
    background-position: center;
    font-family: 'Roboto', sans-serif; /* Clean and modern font */
    font-weight: bold;
    margin: 0;
    padding: 0;
    color: white;
    text-align: center;
    
}

/* Container for Main Content */
.container {
    display: flex;
    flex-wrap: wrap; /* Enable wrapping for responsive design */
    justify-content: center; /* Center content horizontally */
    align-items: center; /* Center content vertically */
    padding: 20px;
    flex: 1; /* Allow container to expand */
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    color: black;
   
}

/* Card Design */
.card {
    background-color:rgba(255, 255, 255, 0.8);
    width: 250px;
    padding: 20px;
    margin: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Elevate cards */
    transition: transform 0.3s; /* Smooth hover effect */
}

.card:hover {
    transform: scale(1.05); /* Slight zoom on hover */
}

.card h2 {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.card p {
    margin-bottom: 20px;
}

.card a {
    display: inline-block;
    padding: 10px;
    background-color: #007bff; /* Button background */
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.card a:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

/* Navigation Styling */
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

/* Footer Styling */
footer {    
    background-color: #ce9883; 
    color: rgb(0, 0, 0);
    text-align: center; 
    padding: 5px; 
    font-weight: bold;
}

/* Dropdown Button for Mobile */
.dropdown-button {
    display: none;
    background-color: #3f51b5;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.dropdown-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.dropdown.open ul {
    display: block; /* Show dropdown when open */
}

/* Media Queries for Mobile */
@media (max-width: 768px) {
    nav {
        flex-direction: column; /* Stack items vertically */
        align-items: flex-start; /* Align items to the left */
    }

    nav ul {
        flex-direction: column; /* Stack links vertically */
        display: none; /* Hide menu initially */
        width: 100%; /* Full-width menu */
        padding: 0;
        background-color: #3f51b5; /* Same color as nav */
    }

    .dropdown-button {
        display: block; /* Show dropdown button on small screens */
        width: 100%;
    }

    .dropdown.open ul {
        display: flex; /* Show menu when open */
        flex-direction: column; /* Stack links */
    }

    nav ul li {
        padding: 10px; /* Add space between items */
        text-align: left; /* Align text to the left */
    }
    
    
}
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Room</title>
    <link rel="icon" href="circular_logo_full.png" type="image/png">
</head>
<body>
    <nav>
        <img src="logo.png" alt="Logo">
        <button class="dropdown-button" onclick="toggleDropdown()">Menu</button>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="changename.php">Account Settings</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>
   
    <h2>Active or Created Rooms</h2>

    <div class="container">
        <?php if (!empty($rooms)): ?>
            <?php foreach ($rooms as $room): ?>
                <div class="card">
                    <h2>Room Name: <?php echo htmlspecialchars($room['RoomName']); ?></h2>
                    <p><strong>Room ID:</strong> <?php echo htmlspecialchars($room['RoomID']); ?></p>
                    <p><strong>Created On:</strong> <?php echo htmlspecialchars($room['JoinTime']); ?></p>
                    <p><strong>Leaved On:</strong> <?php echo htmlspecialchars($room['LeaveTime'] ?? 'N/A'); ?></p>
                    <p><strong>Status:</strong> 
                        <?php
                            // Check if LeaveTime is NULL, indicating the session is ongoing
                            echo $room['LeaveTime'] ? 'Ended' : 'Ongoing';
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No active or created rooms available.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 StudyPark. All rights reserved.</p>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.querySelector('nav ul');
            dropdown.classList.toggle('open');
        }
    </script>
</body>
</html>
