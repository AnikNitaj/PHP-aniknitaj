<?php
include 'config.php';


$stmt = $conn->prepare("SELECT * FROM photos ORDER BY created_at DESC");
$stmt->execute();
$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <style>
        * { box-sizing: border-box; margin:0; padding:0 }
        body { font-family: Arial, Helvetica, sans-serif; background: #fff; color:#111; padding:20px }
        .container { max-width:980px; margin:0 auto }
        header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px }
        header h1 { font-size:1.5rem; font-weight:600; margin:0 }
        header a { padding:8px 12px; text-decoration:none; border:1px solid #ccc; color:inherit; border-radius:3px }
        .gallery { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:16px; margin-bottom:24px }
        .photo-card { background:#fff; border:1px solid #e6e6e6; border-radius:6px; overflow:hidden }
        .photo-card img { width:100%; height:200px; object-fit:cover; display:block }
        .photo-info { padding:12px }
        .photo-info h3 { margin:0 0 6px 0; font-size:1rem }
        .photo-info p { margin:0 0 6px 0; font-size:0.9rem; color:#333 }
        .empty-message { text-align:center; padding:40px; color:#555 }
        footer { text-align:center; padding:12px 0; color:#666; font-size:0.9rem }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Photo Gallery</h1>
            <a href="login.php">Admin Panel</a>
        </header>

        <?php if (count($photos) > 0): ?>
            <div class="gallery">
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-card">
                        <img src="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>">
                        <div class="photo-info">
                            <h3><?php echo htmlspecialchars($photo['title']); ?></h3>
                            <p><?php echo htmlspecialchars($photo['description']); ?></p>
                            <p><small><?php echo date('M d, Y', strtotime($photo['created_at'])); ?></small></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-message">
                <p>No photos available yet. Check back soon!</p>
            </div>
        <?php endif; ?>

        <footer>
            <p>&copy; 2026 Photo Gallery. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
