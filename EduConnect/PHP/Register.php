<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Helper function to sanitize input
    function clean_input($data) {
        return htmlspecialchars(trim($data));
    }

    // Sanitize form data
    $name = clean_input($_POST['name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $userLevel = clean_input($_POST['user_level'] ?? 'user');

    // Initialize error array
    $errors = [];

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // If validation errors exist, show and redirect
    if (!empty($errors)) {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
        echo "<script>window.location.href='../Registration.html';</script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // DB connection
    $servername = "localhost"; 
    $dbUsername = "root";  
    $dbPassword = "";  
    $dbname = "educonnect_db";    

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $sql = "INSERT INTO users (name, email, password, user_level) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing SQL: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $userLevel);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!');</script>";
        echo "<script>window.location.href='../Home.html';</script>";
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
        echo "<script>window.location.href='../Registration.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
