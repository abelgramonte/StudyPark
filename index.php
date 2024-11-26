<?php
session_start(); // Start the session

$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8') : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyPark - Home</title>
    <link rel="icon" href="circular_logo_full.png" type="image/png">
    <link rel="stylesheet" href="index.css">
</head>
<style>
   
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-image: url('studyparkbg.gif');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    font-family: 'Arial', sans-serif;
    font-weight: bold;
    margin: 0;
    padding: 0;
    color: #333;
    justify-content: center;
}

.container {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 50px 20px;
    color: #fff;
    font-size: large;
}

h1 {
    font-size: 3em;
    margin-bottom: 20px;
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.subtext {
    font-size: 1.2em;
    margin-top: -10px;
    color: #666;
    line-height: 1.6;
}

.about-section,
.team-section {
    margin: 50px auto;
    padding: 50px;
    width: 80%;
    max-width: 1000px;
    background: rgba(234, 225, 225, 0.35); /* Transparent background */
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.about-section h2,
.team-section h2 {
    font-size: 2em;
    color: #ffffff;
    margin-bottom: 20px;
}

.team {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.team-member {
    background: rgba(232, 224, 224, 0.42);
    border: 1px solid #dddddd;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    width: 250px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.team-member:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.team-member img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-bottom: 10px;
    object-fit: cover;
}

.team-member h3 {
    margin: 10px 0 5px;
    color: #3f51b5;
}

.team-member p {
    margin: 5px 0;
    font-size: 14px;
    color: #555;
}

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
    font-weight: bolder;

}

nav a {
    color: white;
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

nav a:hover {
    background-color: #a57462;
}

/* Dropdown Button */
.dropdown {
    position: relative;
}

.dropdown-button {
    display: none;
    background-color: #555;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
}

.dropdown-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.dropdown ul {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    list-style: none;
    margin: 0;
    padding: 10px 0;
}

.dropdown ul.open {
    display: block;
}

.dropdown ul li {
    padding: 10px 20px;
    white-space: nowrap;
}

.dropdown ul li a {
    text-decoration: none;
    color: #333;
    font-size: 14px;
}

.dropdown ul li a:hover {
    color: #007BFF;
}

/* Footer Styles */
footer {
    background-color: #ce9883;
    color: white;
    text-align: center;
    padding: 10px 5px;
    font-weight: bold;
    font-size: 0.9em;
}

/* Media Queries */
@media (max-width: 768px) {
    nav {
        flex-direction: column;
        align-items: flex-start;
    }

    nav a:hover {
    background-color: #a57462;
}


    nav ul {
        display: none;
        flex-direction: column;
        width: 100%;
        background-color: #3f51b5;
    }

    .dropdown-button {
        display: block;
        width: 100%;
    }

    .dropdown ul.open {
        display: flex;
        flex-direction: column;
    }

    nav ul li {
        padding: 10px;
        text-align: left;
    }

    .team {
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
        <h1>Welcome to <span class="highlight">StudyPark</span>, <span class="highlight"><?php echo $name; ?>!</span></h1>
        <p class="subtext">Your go-to platform for collaborative learning.</p>
    </div>
    <div class="about-section">
        <h2>About StudyPark</h2>
        <p>
            StudyPark is an innovative platform designed to make collaborative learning easier and more engaging.
            Our mission is to empower students and professionals by providing tools that enhance teamwork, 
            knowledge sharing, and progress tracking in a modern, user-friendly environment.
        </p>
    </div>
    <div class="team-section">
        <h2>Meet the Developers</h2>
        <div class="team">
            <div class="team-member">
                <img src="developer1.jpg" alt="John Doe">
                <h3>John Doe</h3>
                <p><strong>Role:</strong> Frontend Developer</p>
                <p>John designed the user interface to ensure a seamless and engaging user experience for StudyPark.</p>
            </div>
            <div class="team-member">
                <img src="developer2.jpg" alt="Jane Smith">
                <h3>Jane Smith</h3>
                <p><strong>Role:</strong> Backend Developer</p>
                <p>Jane implemented the server-side logic, ensuring the platform runs smoothly and securely.</p>
            </div>
            <div class="team-member">
                <img src="developer3.jpg" alt="Emily Brown">
                <h3>Emily Brown</h3>
                <p><strong>Role:</strong> Database Specialist</p>
                <p>Emily designed and optimized the database structure for efficient data management and retrieval.</p>
            </div>
            <div class="team-member">
                <img src="developer4.jpg" alt="Michael Lee">
                <h3>Michael Lee</h3>
                <p><strong>Role:</strong> Project Manager</p>
                <p>Michael coordinated the team’s efforts and ensured that the project met its milestones on time.</p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 StudyPark. All rights reserved.</p>
    </footer>
</body>
</html>