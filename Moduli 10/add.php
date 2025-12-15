<?php
include_once 'config.php';

$error = '';
if (isset($_POST['submit'])) {
    $name     = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');

    $sql = "INSERT INTO users (name, username, email) VALUES (:name, :username, :email)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Error adding user.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>
<?php if ($error): ?>
    <p><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form action="" method="post">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit" name="submit">Add User</button>
</form>
</body>
</html>
