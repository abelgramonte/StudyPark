<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="circular_logo_full.png" type="image/png">
</head>
<style>
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
    display: flex;
    flex-wrap: wrap;
    justify-content: center;  
    align-items: center;           
    padding: 20px;
    flex: 1;                           
    border-radius: 10px;           
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.card {
    background-color: rgba(255, 255, 255, 0.8);
    width: 250px;
    padding: 20px;
    margin: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}
.card:hover {
    transform: scale(1.05);
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
    background-color: #ce9883;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
.card a:hover {
    background-color: #a57462;  /* Darker shade of the nav bar color on hover */
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
        <a href="index.php"><img src="logo.png" alt="Logo"></a>

        <!-- Static navigation links -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="changename.php">Account Settings</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Create a Room</h2>
            <p>Start a new study room with your friends.</p>
            <a href="create-room.php">Create Room</a>
        </div>

        <div class="card">
            <h2>Join a Room</h2>
            <p>Join an existing room and start collaborating.</p>
            <a href="join-room.php">Join Room</a>
        </div>

        <div class="card">
            <h2>Recent Activity</h2>
            <p>View recent study rooms and sessions.</p>
            <a href="session.php">View Activity</a>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 StudyPark. All rights reserved.</p>
    </footer>
</body>
</html>

