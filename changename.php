<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Username</title>
    <link rel="icon" href="circular_logo_full.png" type="image/png">
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            background-image: url('studyparkbg.gif');
            background-size: cover;         
            background-position: center;    
        }

        nav {
            background-color: transparent;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bolder;
        }

        nav img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        nav ul {
            display: flex;
            gap: 1rem;
            margin: 0;
            padding: 0;
            list-style: none;
            background-color: transparent;
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
            font-weight: bolder;
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

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 1.1em;
            color: #34495e;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            background-color: #ce9883;
            color: white;
            padding: 10px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #a57462;
        }

        .error {
            color: red;
            font-size: 0.9em;
            text-align: center;
        }

        .success {
            color: green;
            font-size: 0.9em;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav>
        <a href=""><img src="logo.png" alt="Logo"></a>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="changename.php">Account Settings</a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Edit Username</h1>
        <form id="usernameForm">
            <label for="username">New Username</label>
            <input type="text" name="username" id="username" value="" required>
            
            <p id="errorMessage" class="error" style="display: none;"></p>
            <p id="successMessage" class="success" style="display: none;"></p>
            
            <button type="submit">Update Username</button>
        </form>
    </div>
    <footer>
        <p>&copy; 2024 StudyPark. All rights reserved.</p>
    </footer>

    <script>
        // Handle form submission
        document.getElementById('usernameForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var newUsername = document.getElementById('username').value.trim();
            var errorMessage = document.getElementById('errorMessage');
            var successMessage = document.getElementById('successMessage');

            // Reset messages
            errorMessage.style.display = 'none';
            successMessage.style.display = 'none';

            // Simple validation
            if (newUsername === '') {
                errorMessage.textContent = 'Username cannot be empty.';
                errorMessage.style.display = 'block';
                return;
            }

            // Send the AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_username.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        successMessage.textContent = 'Username updated successfully!';
                        successMessage.style.display = 'block';

                        // Optionally, update the username dynamically on the page
                        // Example: document.getElementById('userNameDisplay').textContent = newUsername;
                    } else {
                        errorMessage.textContent = response.error;
                        errorMessage.style.display = 'block';
                    }
                } else {
                    errorMessage.textContent = 'An error occurred. Please try again.';
                    errorMessage.style.display = 'block';
                }
            };

            xhr.send('username=' + encodeURIComponent(newUsername));
        });
    </script>
</body>
</html>
