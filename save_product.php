<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "imsbd"; // Your database name
$table = "products"; // The table name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the submitted form data
$productName = $_POST['productName'];
$productId = $_POST['productId'];
$productBarcode = $_POST['productBarcode'];
$productCategory = $_POST['productCategory'];

// Handle the image upload
$imagePath = '';
if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
    if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    } else {
        echo "Error uploading image.";
        exit;
    }
} else {
    echo "Please upload an image.";
    exit;
}

// Insert the product data into the products table
$stmt = $conn->prepare("INSERT INTO $table (id, name, barcode, category, image_path) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $productId, $productName, $productBarcode, $productCategory, $imagePath);

if ($stmt->execute()) {
    echo "Product saved successfully.";
} else {
    echo "Error saving product: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
