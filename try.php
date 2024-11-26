<?php
include 'db.php'; // Include the database connection file
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

// Handle the leave call action if the 'leave' action is received
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'leave') {
    // Update the leave time in the VideoCalls table
    if (isset($_SESSION['call_id'])) {
        $callID = $_SESSION['call_id'];

        $updateLeaveQuery = "UPDATE VideoCalls SET LeaveTime = NOW() WHERE CallID = ?";
        $stmt = $conn->prepare($updateLeaveQuery);
        $stmt->bind_param("i", $callID);

        if ($stmt->execute()) {
            unset($_SESSION['call_id']); // Remove CallID from session
            echo "Leave time updated successfully."; // Optional, for debugging
        } else {
            echo "Error recording leave time: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Studypark</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="circular_logo_full.png" type="image/png">
    <style>
       body {
            background: #0F2027;
            background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);
            background: linear-gradient(to right, #2C5364, #203A43, #0F2027);
        }

        #join-btn {
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -50px;
            margin-left: -100px;
            font-size: 18px;
            padding: 20px 40px;
        }

        #video-streams {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            height: 90vh;
            margin: 0 auto;
        }

        .video-container {
            max-height: 100%;
            border: 2px solid black;
            background-color: #203A49;
        }

        .video-player {
            height: 100%;
            width: 100%;
        }

        button {
            border: none;
            background-color: cadetblue;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            margin: 2px;
            cursor: pointer;
        }

        #stream-controls {
            display: none;
            justify-content: center;
            margin-top: 0.5em;
        }

        @media screen and (max-width: 1400px) {
            #video-streams {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                width: 95%;
            }
        }

        .video-container:hover .video-uid {
            display: block;
        }
    </style>
</head>
<body>

    <button id="join-btn">Join Stream</button>

    <div id="video-streams">
        <!-- Video streams will be appended here dynamically -->
    </div>

    <div id="stream-controls">
        <button id="leave-btn">Leave Stream</button>
        <button id="mic-btn">Mic On</button>
        <button id="camera-btn">Camera On</button>
    </div>

    <!-- Video Elements for Local and Remote Streams -->
    <video id="localVideo" class="video-player" autoplay muted></video>
    <video id="remoteVideo" class="video-player" autoplay></video>

    <script src="AgoraRTC_N-4.22.2.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const joinBtn = document.getElementById('join-btn');
            const leaveBtn = document.getElementById('leave-btn');
            const micBtn = document.getElementById('mic-btn');
            const cameraBtn = document.getElementById('camera-btn');
            const localVideo = document.getElementById('localVideo');
            const remoteVideo = document.getElementById('remoteVideo');
            let localStream = null;
            let isAudioMuted = false;
            let isVideoOff = false;

            // Start local video stream
            async function startLocalVideo() {
                try {
                    localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                    localVideo.srcObject = localStream;
                    document.getElementById('stream-controls').style.display = 'flex';
                    joinBtn.style.display = 'none'; // Hide join button after joining
                } catch (err) {
                    alert("Error accessing camera and microphone.");
                    console.error('Error:', err);
                }
            }

            // Toggle audio
            micBtn.addEventListener('click', () => {
                isAudioMuted = !isAudioMuted;
                micBtn.innerHTML = isAudioMuted ? 'Mic On' : 'Mic Off';
                if (localStream) {
                    localStream.getAudioTracks().forEach(track => track.enabled = !isAudioMuted);
                }
            });

            // Toggle video
            cameraBtn.addEventListener('click', () => {
                isVideoOff = !isVideoOff;
                cameraBtn.innerHTML = isVideoOff ? 'Camera On' : 'Camera Off';
                if (localStream) {
                    localStream.getVideoTracks().forEach(track => track.enabled = !isVideoOff);
                }
            });

            // Start the video call
            joinBtn.addEventListener('click', () => {
                startLocalVideo().then(() => {
                    // You can add further logic here for Agora or video stream joining
                });
            });

            // Leave the stream
            leaveBtn.addEventListener('click', () => {
                // Send leave request to backend
                fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=leave'
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Log the server response
                    // Stop local stream and clean up
                    if (localStream) {
                        localStream.getTracks().forEach(track => track.stop());
                        localVideo.srcObject = null;
                        remoteVideo.srcObject = null;
                    }
                    document.getElementById('stream-controls').style.display = 'none';
                    joinBtn.style.display = 'inline'; // Show join button again
                    window.location.href = 'join-room.php'; // Redirect to join room page
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>
