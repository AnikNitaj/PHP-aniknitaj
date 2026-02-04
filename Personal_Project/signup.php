<?php

$user="root";
$pass="";
$server="localhost";
$dbname="db personal project";

try {
    
    $conn = new PDO("mysql:host=$server;dbname=$dbname",$user,$pass);
    echo "Connected successfully";

} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
           
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            
            if ($stmt->execute()) {
                $success = "User registered successfully!";
                
                header("Refresh: 2; url=login.php");
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Arial,Helvetica,sans-serif;background:#fff;color:#111;display:flex;justify-content:center;align-items:center;min-height:100vh;padding:16px}
        .signup-container{background:#fff;border:1px solid #e6e6e6;padding:20px;border-radius:6px;width:100%;max-width:420px}
        h1{font-size:1.2rem;margin:0 0 12px 0;text-align:center}
        .form-group{margin-bottom:12px}
        label{display:block;margin-bottom:6px}
        input{width:100%;padding:10px;border:1px solid #ccc;border-radius:4px}
        button{width:100%;padding:10px;border:1px solid #bbb;background:#f8f8f8;cursor:pointer}
        .error{padding:10px;background:#fff8f8;color:#900;margin-bottom:10px}
        .success{padding:10px;background:#f8fff8;color:#080;margin-bottom:10px}
        .login-link{text-align:center;margin-top:10px}
        .login-link a{text-decoration:none;color:inherit}
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Log In</a>
        </div>
    </div>
</body>
</html>
