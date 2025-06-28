<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "educonnect_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$course = $_POST['course'];
$enroll_date = $_POST['enroll_date'];
$qualification = $_POST['comments'];

$sql = "INSERT INTO enrollments (name, email, phone, course, enroll_date, qualifications)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $phone, $course, $enroll_date, $qualification);

if ($stmt->execute()) {
    header("Location: ../Reservation.html?success=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
