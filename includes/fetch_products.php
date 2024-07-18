<?php

require 'db-connect.php';


// Fetch products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    // Handle case when there are no products in the database
    $products = ["message" => "No products found"];
}

// Close connection
$conn->close();

// Set content type to JSON
header('Content-Type: application/json');

// Output products as JSON
echo json_encode($products);

?>
