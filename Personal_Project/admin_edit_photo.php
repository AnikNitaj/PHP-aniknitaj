<?php
include 'config.php';


if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$photo = null;


$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM photos WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$photo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$photo) {
    header('Location: admin_dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    
    $stmt = $conn->prepare("UPDATE photos SET title = :title, description = :description WHERE id = :id");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $success = 'Photo updated successfully!';
        $photo['title'] = $title;
        $photo['description'] = $description;
    } else {
        $error = 'Database error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Arial,Helvetica,sans-serif;background:#fff;color:#111}
        .container{max-width:600px;margin:24px auto;padding:12px}
        .form-card{background:#fff;border:1px solid #e6e6e6;padding:18px;border-radius:4px}
        h1{margin:0 0 12px 0;font-size:1.1rem}
        .photo-preview{width:100%;max-height:300px;object-fit:cover;border-radius:4px;margin-bottom:12px}
        .form-group{margin-bottom:12px}
        label{display:block;margin-bottom:6px}
        input[type=text],textarea{width:100%;padding:10px;border:1px solid #ccc;border-radius:4px}
        textarea{min-height:100px}
        .button-group{display:flex;gap:8px;margin-top:12px}
        button,a.btn{flex:1;padding:10px;border:1px solid #ccc;background:#f8f8f8;text-decoration:none;color:inherit;border-radius:4px}
        .success{padding:10px;background:#f8fff8;color:#080;margin-bottom:10px}
        .error{padding:10px;background:#fff8f8;color:#900;margin-bottom:10px}
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h1>Edit Photo</h1>

            <?php if ($success): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <img src="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" class="photo-preview">

            <form method="POST">
                <div class="form-group">
                    <label for="title">Photo Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($photo['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($photo['description']); ?></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-primary">Save Changes</button>
                    <a href="admin_dashboard.php" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
