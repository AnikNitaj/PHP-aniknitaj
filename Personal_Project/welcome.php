<?php
session_start(); // start session

// Check if user is logged in via session
if (!isset($_SESSION['username'])) {
    // If session not set, check for "remember me" cookie
    if (isset($_COOKIE['user_id'])) {
        // Connect to your database
        $conn = new mysqli("localhost", "root", "", "personal_project");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get user info from cookie ID
        $id = $_COOKIE['user_id'];
        $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $_SESSION['username'] = $user['username']; // restore session
        } else {
            // No matching user, redirect to login
            header("Location: login.html");
            exit();
        }

        $stmt->close();
        $conn->close();
    } else {
        // No session or cookie, redirect to login
        header("Location: login.html");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>You are now logged in.</p>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
