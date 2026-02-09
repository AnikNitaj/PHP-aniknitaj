<?php
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';


    if ($identifier === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $identifier;
        header('Location: admin_dashboard.php');
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = :ident OR email = :ident LIMIT 1");
        $stmt->bindParam(':ident', $identifier);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid username/email or password';
        }
    } catch (PDOException $e) {
        $error = 'Database error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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
            padding:20px;
        }
        .login-container{
            background:#ffffff;
            padding:40px;
            border-radius:16px;
            width:100%;
            max-width:380px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        h1{
            text-align:center;
            font-size:1.75rem;
            margin-bottom:8px;
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
            color:#1d1d1f;
            font-weight:500;
            font-size:0.95rem;
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
            transform: translateY(-2px);
        }
        button:active{
            transform: scale(0.98);
        }
        .error-message{
            background:#FEE;
            color:#D70015;
            padding:12px;
            border-radius:8px;
            margin-bottom:16px;
            font-size:0.95rem;
            border-left:4px solid #D70015;
        }
        .back-link{
            text-align:center;
            margin-top:16px;
        }
        .back-link a{
            text-decoration:none;
            color:#0A84FF;
            font-weight:600;
            font-size:0.95rem;
            transition: color 0.2s ease;
        }
        .back-link a:hover{
            color:#0071E3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <p class="subtitle">Access your gallery</p>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="back-link">
            <a href="signup.php">← Create New Account</a>
        </div>
    </div>
</body>
</html>
