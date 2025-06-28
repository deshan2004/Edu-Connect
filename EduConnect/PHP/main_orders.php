<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "educonnect_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if data is received
if ($data && isset($data['customer_name']) && isset($data['items'])) {
    $customerName = $conn->real_escape_string($data['customer_name']);
    $items = $data['items'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO orders (item_name, quantity, total_price, customer_name) VALUES (?, ?, ?, ?)");

    if ($stmt) {
        foreach ($items as $item) {
            $stmt->bind_param("sids", $item['item_name'], $item['quantity'], $item['total_price'], $customerName);
            $stmt->execute();
        }
        $stmt->close();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare the SQL statement.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid order data.']);
}

$conn->close();
?>
