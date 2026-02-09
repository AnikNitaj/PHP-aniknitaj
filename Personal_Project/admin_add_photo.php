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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background:#ffffff;
            color:#1d1d1f;
        }
        header{
            padding:20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:24px;
            background:#f5f5f7;
            border-radius:0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        header h1{
            font-size:1.75rem;
            margin:0;
            font-weight:700;
            letter-spacing: -0.02em;
        }
        .header-controls{
            display:flex;
            align-items:center;
            gap:16px;
        }
        .btn-group{display:flex;gap:8px}
        a.btn,button{
            padding:10px 16px;
            border:none;
            background:#0A84FF;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
            cursor:pointer;
            font-weight:600;
            font-size:0.95rem;
            transition: all 0.2s ease;
        }
        a.btn:hover,button:hover{
            background:#0071E3;
            box-shadow: 0 4px 12px rgba(10,132,255,0.3);
        }
        a.btn.secondary{
            background:#e6e6e6;
            color:#1d1d1f;
        }
        a.btn.secondary:hover{
            background:#d0d0d0;
        }
        .container{max-width:600px;margin:0 auto;padding:20px}
        .form-card{background:#ffffff;padding:24px;border-radius:12px;box-shadow: 0 1px 3px rgba(0,0,0,0.08)}
        h2{margin:0 0 16px 0;font-size:1.5rem;font-weight:700}
        .form-group{margin-bottom:16px}
        label{display:block;margin-bottom:8px;font-weight:500;color:#1d1d1f}
        input[type=text],textarea,select{
            width:100%;
            padding:12px;
            border:1px solid #e0e0e0;
            border-radius:8px;
            font-size:1rem;
            font-family:inherit;
            transition: all 0.2s ease;
        }
        input[type=text]:focus,textarea:focus,select:focus{
            outline:none;
            border-color:#0A84FF;
            box-shadow: 0 0 0 3px rgba(10,132,255,0.1);
        }
        textarea{min-height:100px;resize:vertical}
        .button-group{display:flex;gap:8px;margin-top:20px}
        button,a.btn{flex:1;padding:12px;border:none;background:#0A84FF;text-decoration:none;color:#fff;border-radius:8px;cursor:pointer;font-weight:600}
        button:disabled{background:#e6e6e6;color:#999;cursor:not-allowed}
        button:hover:not(:disabled){background:#0071E3;box-shadow: 0 4px 12px rgba(10,132,255,0.3)}
        .success{padding:12px;background:#EFF;color:#007500;margin-bottom:16px;border-radius:8px;border-left:4px solid #007500}
        .error{padding:12px;background:#FEE;color:#D70015;margin-bottom:16px;border-radius:8px;border-left:4px solid #D70015}
        .warning{padding:12px;background:#FFF8E1;color:#B8860B;margin-bottom:16px;border-radius:8px;border-left:4px solid #B8860B}
    </style>
</head>
<body>
    <header>
        <h1>Add Photo</h1>
        <div class="header-controls">
            <div class="btn-group">
                <a href="admin_dashboard.php" class="btn secondary">← Back</a>
                <a href="logout.php" class="btn secondary">Logout</a>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="form-card">
            <h2>Add New Photo</h2>

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
                    <div class="warning">
                        No images found in uploads/ folder. Please add image files there first.
                    </div>
                <?php endif; ?>

                <div class="button-group">
                    <button type="submit" <?php echo empty($available_images) ? 'disabled' : ''; ?>>Add Photo</button>
                    <a href="admin_dashboard.php" class="btn secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
