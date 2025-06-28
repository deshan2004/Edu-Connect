<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection details
    $servername = "localhost"; 
    $dbUsername = "root";  
    $dbPassword = "";  
    $dbname = "educonnect_db";    

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "SELECT id, name, email, password, user_level FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Check if prepare() failed
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("s", $email);

    // Execute SQL statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($id, $name, $dbEmail, $dbPassword, $userLevel);

    // Fetch the result
    if ($stmt->fetch()) {
        if (($userLevel == 'admin' || $userLevel == 'staff') && $password === $dbPassword) {
            // Password is correct for admin/staff with plain text password
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $dbEmail;
            $_SESSION['user_level'] = $userLevel;

            if ($userLevel == 'admin') {
                echo "<script>alert('Login successful! Redirecting to admin dashboard...');</script>";
                echo "<script>window.location.href='../admin.html';</script>";
            } elseif ($userLevel == 'staff') {
                echo "<script>alert('Login successful! Redirecting to staff dashboard...');</script>";
                echo "<script>window.location.href='../Staff.html';</script>";
            }
        } elseif ($userLevel == 'user' && password_verify($password, $dbPassword)) {
            // Password is correct for regular user with hashed password
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $dbEmail;
            $_SESSION['user_level'] = $userLevel;

            echo "<script>alert('Login successful! Redirecting to user dashboard...');</script>";
            echo "<script>window.location.href='../index.html';</script>";
        } else {
            // Invalid password
            echo "<script>alert('Invalid password!');</script>";
            echo "<script>window.location.href='../Home.html';</script>";
        }
    } else {
        // No user found with that email
        echo "<script>alert('No user found with that email!');</script>";
        echo "<script>window.location.href='../Home.html';</script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
