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
            background:#ffffff;
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
        .photo-preview{width:100%;max-height:300px;object-fit:cover;border-radius:8px;margin-bottom:16px}
        .form-group{margin-bottom:16px}
        label{display:block;margin-bottom:8px;font-weight:500;color:#1d1d1f}
        input[type=text],textarea{
            width:100%;
            padding:12px;
            border:1px solid #e0e0e0;
            border-radius:8px;
            font-size:1rem;
            font-family:inherit;
            transition: all 0.2s ease;
        }
        input[type=text]:focus,textarea:focus{
            outline:none;
            border-color:#0A84FF;
            box-shadow: 0 0 0 3px rgba(10,132,255,0.1);
        }
        textarea{min-height:100px;resize:vertical}
        .button-group{display:flex;gap:8px;margin-top:20px}
        button,a.btn{flex:1;padding:12px;border:none;background:#0A84FF;text-decoration:none;color:#fff;border-radius:8px;cursor:pointer;font-weight:600}
        .success{padding:12px;background:#EFF;color:#007500;margin-bottom:16px;border-radius:8px;border-left:4px solid #007500}
        .error{padding:12px;background:#FEE;color:#D70015;margin-bottom:16px;border-radius:8px;border-left:4px solid #D70015}
    </style>
</head>
<body>
    <header>
        <h1>Edit Photo</h1>
        <div class="header-controls">
            <div class="btn-group">
                <a href="admin_dashboard.php" class="btn secondary">← Back</a>
                <a href="logout.php" class="btn secondary">Logout</a>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="form-card">
            <h2>Edit Photo</h2>

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
                    <a href="admin_dashboard.php" class="btn secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
