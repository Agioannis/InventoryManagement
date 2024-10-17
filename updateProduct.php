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
$image_path = $_POST['image_path'];
$name = $_POST['name'];
$barcode = $_POST['barcode'];
$category = $_POST['category'];

// Update the product
$sql = "UPDATE products SET image_path = ?, name = ?, barcode = ?, category = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $image_path, $name, $barcode, $category, $id);

if ($stmt->execute()) {
    echo "Product updated successfully.";
} else {
    echo "Error updating product: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
