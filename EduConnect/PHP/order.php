<?php
// Check if POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database credentials
    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your username
    $password = ""; // Replace with your password
    $dbname = "educonnect_db"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve raw POST data
    $postData = file_get_contents('php://input');

    // Decode JSON data
    $data = json_decode($postData, true);

    // Retrieve customer name and cart items from the decoded data
    $customerName = $data['name'];
    $cartItems = $data['items'];
    $totalPrice = $data['totalPrice'];

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO orders (item_name, quantity, total_price, customer_name) VALUES (?, ?, ?, ?)");

    $stmt->bind_param("sids", $itemName, $quantity, $itemTotalPrice, $customerName);

    // Insert each item from cart into orders table
    foreach ($cartItems as $item) {
        $itemName = $item['itemName'];
        $quantity = $item['quantity'];
        $itemTotalPrice = $item['totalPrice'];

        $stmt->execute();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Send response back (optional)
    echo json_encode(['success' => true, 'message' => 'Order placed successfully.']);
} else {
    // Redirect or handle error as needed
    header('Location: index.html');
}
?>
