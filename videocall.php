<?php
include 'db.php'; // Include the database connection file
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if user is not logged in
    exit;
}



// Get room details from URL
$roomName = $_GET['room'];
$userID = $_SESSION['user_id'];

// Check if the room exists
$checkRoomQuery = "SELECT RoomID FROM Rooms WHERE RoomName = ?";
$stmt = $conn->prepare($checkRoomQuery);
$stmt->bind_param("s", $roomName);
$stmt->execute();
$roomResult = $stmt->get_result();

if ($roomResult->num_rows > 0) {
    $room = $roomResult->fetch_assoc();
    $roomID = $room['RoomID'];

    // Log user's join time in the VideoCalls table
    $logJoinQuery = "INSERT INTO VideoCalls (RoomID, RoomName, UserID, JoinTime) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($logJoinQuery);
    $stmt->bind_param("isi", $roomID, $roomName, $userID);
    if ($stmt->execute()) {
        $callID = $conn->insert_id; // Get the ID of the current call
        $_SESSION['call_id'] = $callID; // Store CallID in the session
    } else {
        die("Error logging join time: " . $conn->error);
    }
} else {
    die("Room not found!");
}

// Handle the leave call action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['leave-room'])) {
    $callID = $_SESSION['call_id'];
    $updateLeaveQuery = "UPDATE VideoCalls SET LeaveTime = NOW() WHERE CallID = ?";
    $stmt = $conn->prepare($updateLeaveQuery);
    $stmt->bind_param("i", $callID);
    if ($stmt->execute()) {
        unset($_SESSION['call_id']); // Remove CallID from session
        header("Location: join-room.php");
        exit;
    } else {
        die("Error recording leave time: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Call</title>
    <link rel="icon" href="circular_logo_full.png" type="image/png">
    <link rel="stylesheet" href="video.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav>
        <a href="index.php"><img src="logo.png" alt="Logo"></a>
        <div class="dropdown">
            <button class="dropdown-button" onclick="toggleDropdown()">Menu</button>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Video Call: <?php echo htmlspecialchars($roomName); ?></h1>
        <div class="video-section">
            <video id="localVideo" autoplay muted playsinline>
                <p>Your browser doesn't support HTML5 video.</p>
            </video>
            <video id="remoteVideo" autoplay playsinline>
                <p>Your browser doesn't support HTML5 video.</p>
            </video>
        </div>
        <div class="controls">
            <button id="startCall">
                <i class="fas fa-phone"></i> Start Call
            </button>
            <button id="endCall">
                <i class="fas fa-phone-slash"></i> End Call
            </button>
            <button id="toggleAudio">
                <i class="fas fa-microphone"></i> Mute
            </button>
            <button id="toggleVideo">
                <i class="fas fa-video"></i> Video
            </button>
        </div>
        <form method="POST">
            <input type="hidden" name="leave-room" value="1">
            <button type="submit" id="leaveRoom">
                <i class="fas fa-door-open"></i> Leave Room
            </button>
        </form>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.querySelector('.dropdown');
            dropdown.classList.toggle('open');
        }

        document.addEventListener('DOMContentLoaded', function () {
    const startCallBtn = document.getElementById('startCall');
    const endCallBtn = document.getElementById('endCall');
    const toggleAudioBtn = document.getElementById('toggleAudio');
    const toggleVideoBtn = document.getElementById('toggleVideo');

    const localVideo = document.getElementById('localVideo');
    const remoteVideo = document.getElementById('remoteVideo');
    let localStream = null;
    let isAudioMuted = false;
    let isVideoOff = false;

    // Start local video
    async function startLocalVideo() {
        try {
            localStream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });
            localVideo.srcObject = localStream;
        } catch (err) {
            alert("Error accessing camera and microphone.");
            console.error('Error:', err);
        }
    }

    // Toggle audio
    toggleAudioBtn.addEventListener('click', () => {
        isAudioMuted = !isAudioMuted;
        toggleAudioBtn.innerHTML = isAudioMuted ? 
            '<i class="fas fa-microphone-slash"></i> Unmute' : 
            '<i class="fas fa-microphone"></i> Mute';
        if (localStream) {
            localStream.getAudioTracks().forEach(track => track.enabled = !isAudioMuted);
        }
    });

    // Toggle video
    toggleVideoBtn.addEventListener('click', () => {
        isVideoOff = !isVideoOff;
        toggleVideoBtn.innerHTML = isVideoOff ? 
            '<i class="fas fa-video-slash"></i> Start Video' : 
            '<i class="fas fa-video"></i> Video';
        if (localStream) {
            localStream.getVideoTracks().forEach(track => track.enabled = !isVideoOff);
        }
    });

    // Start call with redirection
    startCallBtn.addEventListener('click', () => {
        startLocalVideo().then(() => {
            // Redirect to try.html after starting the video
            window.location.href = 'try.html';
        });
    });

    // End call
    endCallBtn.addEventListener('click', () => {
        startCallBtn.disabled = false;
        endCallBtn.disabled = true;
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localVideo.srcObject = null;
            localStream = null;
        }
    });
});

    </script>

    <footer>
        <p>&copy; 2024 StudyPark. All rights reserved.</p>
    </footer>
</body>
</html>