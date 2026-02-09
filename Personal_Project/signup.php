<?php

$user="root";
$pass="";
$server="localhost";
$dbname="db personal project";

try {
    
    $conn = new PDO("mysql:host=$server;dbname=$dbname",$user,$pass);

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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background: #ffffff; 
            color:#1d1d1f;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            padding:16px;
        }
        .signup-container{
            background:#ffffff;
            padding:32px;
            border-radius:12px;
            width:100%;
            max-width:380px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        h1{
            font-size:1.75rem;
            margin:0 0 8px 0;
            text-align:center;
            font-weight:700;
            letter-spacing: -0.02em;
        }
        .subtitle{
            text-align:center;
            color:#666;
            margin:0 0 28px 0;
            font-size:0.95rem;
        }
        .form-group{margin-bottom:16px}
        label{
            display:block;
            margin-bottom:8px;
            font-weight:500;
            font-size:0.95rem;
            color:#1d1d1f;
        }
        input{
            width:100%;
            padding:12px;
            border:1px solid #e0e0e0;
            border-radius:8px;
            font-size:1rem;
            font-family: inherit;
            color:#1d1d1f;
        }
        input:focus{
            outline:none;
            border-color:#0A84FF;
            box-shadow: 0 0 0 3px rgba(10,132,255,0.1);
        }
        button{
            width:100%;
            padding:12px;
            border:none;
            background:#0A84FF;
            color:#fff;
            font-size:1rem;
            font-weight:600;
            border-radius:8px;
            cursor:pointer;
            transition: all 0.2s ease;
            margin-top:8px;
        }
        button:hover{
            background:#0071E3;
            box-shadow: 0 4px 12px rgba(10,132,255,0.3);
        }
        button:active{
            transform: scale(0.98);
        }
        .error{
            padding:12px;
            background:#FEE;
            color:#D70015;
            margin-bottom:16px;
            border-radius:8px;
            font-size:0.95rem;
            border-left:4px solid #D70015;
        }
        .success{
            padding:12px;
            background:#EFF;
            color:#007500;
            margin-bottom:16px;
            border-radius:8px;
            font-size:0.95rem;
            border-left:4px solid #007500;
        }
        .login-link{
            text-align:center;
            margin-top:16px;
            color:#333;
            font-size:0.95rem;
        }
        .login-link a{
            text-decoration:none;
            color:#0A84FF;
            font-weight:600;
            transition: color 0.2s ease;
        }
        .login-link a:hover{
            color:#0071E3;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Create Account</h1>
        <p class="subtitle">Join our photo gallery</p>

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
            Already have an account? <a href="login.php">Sign In</a>
        </div>
    </div>
</body>
</html>
