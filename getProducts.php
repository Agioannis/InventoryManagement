<?php 
// Database credentials
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'imsbd';

// Create a connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT id, image_path AS image, name, barcode, category FROM products"; // Update SQL query
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // For debugging
}

$products = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Return the products as JSON
echo json_encode($products);

// Close the database connection
$conn->close();
?>