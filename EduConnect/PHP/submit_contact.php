<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "educonnect_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$message = $_POST['message'];

$sql = "INSERT INTO contacts (name, email, address, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $address, $message);
$stmt->execute();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Message Sent</title>

  
  <script>


    alert("Your message has been sent successfully!");

    window.location.href = "../index.html";

  </script>
</head>
<body>
</body>
</html>
