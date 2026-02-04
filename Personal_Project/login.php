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
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Arial,Helvetica,sans-serif;background:#fff;color:#111;display:flex;justify-content:center;align-items:center;min-height:100vh;padding:20px}
        .login-container{background:#fff;padding:24px;border:1px solid #e6e6e6;width:100%;max-width:360px}
        h1{text-align:center;font-size:1.25rem;margin-bottom:18px}
        .form-group{margin-bottom:12px}
        label{display:block;margin-bottom:6px;color:#222}
        input{width:100%;padding:10px;border:1px solid #ccc;border-radius:4px}
        button{width:100%;padding:10px;border:1px solid #aaa;background:#f5f5f5;cursor:pointer}
        .error-message{background:#fff;color:#900;padding:10px;border-left:4px solid #900;margin-bottom:12px}
        .back-link{text-align:center;margin-top:12px}
        .back-link a{text-decoration:none;color:#222}
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        
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
            <a href="index.php">← Back to Gallery</a>
        </div>
    </div>
</body>
</html>
