<?php
include 'config.php';


if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}


try {
    $stmt = $conn->prepare("SELECT * FROM photos ORDER BY created_at DESC");
    $stmt->execute();
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    
    if ($e->getCode() === '42S02' || strpos($e->getMessage(), '1146') !== false) {
        $createSql = "CREATE TABLE IF NOT EXISTS photos (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            filename VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        try {
            $conn->exec($createSql);
            $stmt = $conn->prepare("SELECT * FROM photos ORDER BY created_at DESC");
            $stmt->execute();
            $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e2) {
            echo "<div style='padding:20px;background:#fee;color:#900;border:1px solid #900;'>Database error: " . htmlspecialchars($e2->getMessage()) . "</div>";
            exit;
        }
    } else {
        echo "<div style='padding:20px;background:#fee;color:#900;border:1px solid #900;'>Database error: " . htmlspecialchars($e->getMessage()) . "</div>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background:#ffffff;
            color:#1d1d1f;
        }
        .container{max-width:1200px;margin:0 auto;padding:20px}
        header{
            padding:20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:24px;
            background:#ffffff;
            border-radius:12px;
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
        .welcome{
            color:#666;
            font-size:0.95rem;
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
        .gallery-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
            gap:16px;
            margin-bottom:24px;
        }
        .photo-card{
            background:#ffffff;
            border-radius:12px;
            overflow:hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position:relative;
        }
        .photo-card:hover{
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }
        .photo-card img{
            width:100%;
            height:160px;
            object-fit:cover;
            display:block;
        }
        .photo-details{
            padding:12px;
        }
        .photo-details h3{
            font-size:0.95rem;
            font-weight:600;
            margin:0 0 4px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .photo-details p{
            font-size:0.85rem;
            color:#666;
            margin:0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .photo-actions{
            padding:8px 12px;
            display:flex;
            gap:6px;
            border-top:1px solid #f0f0f0;
        }
        .btn-small{
            flex:1;
            padding:6px 8px;
            font-size:0.85rem;
            background:#f0f0f0;
            color:#1d1d1f;
            border:none;
            border-radius:6px;
            cursor:pointer;
            transition: all 0.2s ease;
            text-decoration:none;
            text-align:center;
        }
        .btn-small:hover{
            background:#e6e6e6;
        }
        .btn-delete{
            background:#FEE;
            color:#D70015;
        }
        .btn-delete:hover{
            background:#FFCCCC;
        }
        .empty-message{
            text-align:center;
            padding:60px 20px;
            background:#f5f5f7;
            border-radius:12px;
            color:#999;
            font-size:1.05rem;
        }
        .empty-message a{
            color:#0A84FF;
            text-decoration:none;
            font-weight:600;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Library</h1>
            <div class="header-controls">
                <span class="welcome">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <div class="btn-group">
                    <a href="admin_add_photo.php" class="btn">+ Add</a>
                    <a href="logout.php" class="btn secondary">Logout</a>
                </div>
            </div>
        </header>
        
        <?php if (count($photos) > 0): ?>
            <div class="gallery-grid">
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-card">
                        <img src="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>">
                        <div class="photo-details">
                            <h3><?php echo htmlspecialchars($photo['title']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($photo['description'], 0, 40)); ?></p>
                        </div>
                        <div class="photo-actions">
                            <a href="admin_edit_photo.php?id=<?php echo $photo['id']; ?>" class="btn-small">Edit</a>
                            <form method="POST" action="admin_delete_photo.php" style="flex:1">
                                <input type="hidden" name="id" value="<?php echo $photo['id']; ?>">
                                <button type="submit" class="btn-small btn-delete" onclick="return confirm('Delete this photo?')">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-message">
                <p>✨ No photos yet</p>
                <p style="font-size:0.9rem;margin-top:8px"><a href="admin_add_photo.php">Add your first photo</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
