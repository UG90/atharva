<?php
session_start();

// Database connection (you should replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "ft5afvaf";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the submitted form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // You should sanitize and validate user input here to prevent SQL injection and other security issues.
    
    // Check user credentials in the database
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Authentication successful
        $_SESSION["username"] = $username;
        header("Location: dashboard.php"); // Redirect to a dashboard or home page
        exit();
    } else {
        // Authentication failed
        echo "Invalid username or password. Please try again.";
    }
}

$conn->close();
?>
