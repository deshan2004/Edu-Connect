<?php
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

// Function to delete an order by ID
function deleteOrder($conn, $orderId) {
    $sql = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();
}

// Function to confirm an order by ID
function confirmOrder($conn, $orderId) {
    // Update item_name to add "Confirmed" in front of the current item_name
    $sql = "UPDATE orders SET item_name = CONCAT(item_name, '(Confirmed)') WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();
}

// Check if cancel button is clicked and process deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cancel_order'])) {
        $orderId = $_POST['order_id'];
        deleteOrder($conn, $orderId);
        // Redirect or refresh page after deletion
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } elseif (isset($_POST['confirm_order'])) {
        $orderId = $_POST['order_id'];
        confirmOrder($conn, $orderId);
        // Redirect or refresh page after confirmation
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

// Query to retrieve orders data
$sql = "SELECT id, item_name, quantity, total_price, customer_name FROM orders";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EDUCONNECT</title>
        <link rel="stylesheet" href="../Style/About.css" />
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                line-height: 1.6;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 1100px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            .sub-header {
                background-color: #333;
                color: #fff;
                padding: 10px 20px;
                text-align: center;
            }

            .sub-header h1 {
                margin: 0;
                padding: 20px 0;
                font-size: 2.5rem;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table th,
            table td {
                padding: 12px;
                text-align: center;
                border: 1px solid #ddd;
            }

            table th {
                background-color: #f2f2f2;
                color: #333;
                font-weight: bold;
                text-transform: uppercase;
            }

            table tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            table tbody tr:hover {
                background-color: #f2f2f2;
            }

            .btn-cancel, .btn-confirm {
                padding: 8px 16px;
                cursor: pointer;
                border: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
                font-weight: bold;
                text-transform: uppercase;
            }

            .btn-cancel {
                background-color: #ff6666;
                color: white;
            }

            .btn-confirm {
                background-color: #4CAF50;
                color: white;
            }

            .btn-cancel:hover, .btn-confirm:hover {
                background-color: #e60000;
            }

        </style>
    </head>
    <body>
    <!-- Header Section -->
    <section class="sub-header">
        <nav>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="../staff.html">HOME</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        <h1>ORDERS</h1>
    </section>

    <!-- Order Table Section -->
    <div class="container">
        <table>
            <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Customer Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="cancel_order" class='btn-cancel'>Cancel</button>
                            <button type="submit" name="confirm_order" class='btn-confirm'>Confirm</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <section class="footer">
        <h4>orders</h4>
        <h4>Gallery Café</h4>
        
    
        <div class="icons">
            <i class="fa fa-facebook"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-instagram"></i>
            <i class="fa fa-linkedin"></i>
        </div>
        <p>Made with <i class="fa fa-heart-o"></i></p>
    </section>

    <!-- JavaScript for menu toggle -->
    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu() {
            navLinks.style.right = "0";
        }
        function hideMenu() {
            navLinks.style.right = "-200px";
        }
    </script>
    </body>
    </html>
    <?php
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
