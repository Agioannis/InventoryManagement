<?php
session_start();

// Database connection
$host = 'localhost'; // Change if necessary
$dbname = 'imsbd'; // Replace with your actual database name
$username = 'root'; // Change if necessary
$password = ''; // Change if necessary

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given email exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Now retrieve the stored password
        $storedPassword = $user['password']; // Assuming 'password' is the column name in your database

        // Verify the password
        if ($password === $storedPassword) {
            // Credentials are correct
            $_SESSION['user'] = $user['id']; // Store user ID in session

            // Respond with success
            echo json_encode(['status' => 'success', 'message' => 'Login successful.']);
        } else {
            // Incorrect password, respond with error
            echo json_encode(['status' => 'error', 'type' => 'password', 'message' => 'Incorrect password.']);
        }
    } else {
        // Email not found, respond with error
        echo json_encode(['status' => 'error', 'type' => 'user', 'message' => 'User not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

$conn->close();
?>
