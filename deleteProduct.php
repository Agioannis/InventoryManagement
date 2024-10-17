<?php
$servername = "localhost";
$username = "root"; // Adjust your database username
$password = ""; // Adjust your database password
$dbname = "imsbd"; // Adjust your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the POST data
$id = $_POST['id'];

// Delete the product
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Product deleted successfully.";
} else {
    echo "Error deleting product: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
