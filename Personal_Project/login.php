<?php
session_start(); // must start session first

$conn = new mysqli("localhost", "root", "", "personal_project");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$email = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // store in session
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        // optional: Remember me cookie (30 days)
        if (isset($_POST['remember'])) {
            setcookie("user_id", $user['id'], time() + (30*24*60*60), "/");
        }

        header("Location: welcome.php");
        exit();
    } else {
        echo "Incorrect password!";
    }
} else {
    echo "No user found with that email.";
}

$stmt->close();
$conn->close();
?>
