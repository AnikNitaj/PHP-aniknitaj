<?php
include 'config.php';


if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$success = '';
$error = '';

// Get list of available images
$uploads_dir = 'uploads/';
$available_images = [];
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (is_dir($uploads_dir)) {
    $files = scandir($uploads_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($file_ext, $allowed_ext)) {
                $available_images[] = $file;
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $filename = $_POST['filename'] ?? '';
    
    if (empty($title)) {
        $error = 'Photo title is required';
    } elseif (empty($filename)) {
        $error = 'Please select a photo from the list';
    } else {
        // Verify the file exists
        $file_path = $uploads_dir . $filename;
        if (!file_exists($file_path)) {
            $error = 'Selected file not found';
        } else {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO photos (title, description, filename) VALUES (:title, :description, :filename)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':filename', $filename);
            
            if ($stmt->execute()) {
                $success = 'Photo added successfully!';
                $title = '';
                $description = '';
            } else {
                $error = 'Database error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Photo</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Arial,Helvetica,sans-serif;background:#fff;color:#111}
        .container{max-width:600px;margin:24px auto;padding:12px}
        .form-card{background:#fff;border:1px solid #e6e6e6;padding:18px;border-radius:4px}
        h1{margin:0 0 12px 0;font-size:1.1rem}
        .form-group{margin-bottom:12px}
        label{display:block;margin-bottom:6px}
        input[type=text],textarea,select{width:100%;padding:10px;border:1px solid #ccc;border-radius:4px}
        textarea{min-height:100px}
        select{font-family:inherit}
        .button-group{display:flex;gap:8px;margin-top:12px}
        button,a.btn{flex:1;padding:10px;border:1px solid #ccc;background:#f8f8f8;text-decoration:none;color:inherit;border-radius:4px;cursor:pointer}
        button:disabled{background:#e6e6e6;color:#999;cursor:not-allowed}
        .success{padding:10px;background:#f8fff8;color:#080;margin-bottom:10px}
        .error{padding:10px;background:#fff8f8;color:#900;margin-bottom:10px}
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h1>Add New Photo</h1>

            <?php if ($success): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="title">Photo Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="filename">Select Photo from Uploads Folder</label>
                    <select id="filename" name="filename" required>
                        <option value="">-- Choose a photo --</option>
                        <?php foreach ($available_images as $img): ?>
                            <option value="<?php echo htmlspecialchars($img); ?>">
                                <?php echo htmlspecialchars($img); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if (empty($available_images)): ?>
                    <div style="padding:10px;background:#fff8f8;color:#900;margin-bottom:10px">
                        No images found in uploads/ folder. Please add image files there first.
                    </div>
                <?php endif; ?>

                <div class="button-group">
                    <button type="submit" <?php echo empty($available_images) ? 'disabled' : ''; ?>>Add Photo</button>
                    <a href="admin_dashboard.php" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
