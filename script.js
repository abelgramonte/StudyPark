document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    // Get form values
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Example validation (you can replace this with actual validation logic)
    if (email && password) {
        // Redirect to index page (your homepage)
        window.location.href = "index.html";
    } else {
        // Optionally, display an error message if the fields are empty
        alert("Please enter both email and password.");
    }
});
