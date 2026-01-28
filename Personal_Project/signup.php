<?php
// 1. Connect to database
$conn = new mysqli("localhost", "root", "", "personal_project");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get data
$username = trim($_POST['username']);
$email    = trim($_POST['email']);
$password = $_POST['password'];

// 3. Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 4. Insert into DB
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    // redirect to login page
    header("Location: login.html");
    exit();
} else {
    echo "Error: Username or email may already exist.";
}

$stmt->close();
$conn->close();
?>
