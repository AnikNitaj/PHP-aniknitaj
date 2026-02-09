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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin:0; padding:0 }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            background: #ffffff; 
            color:#1d1d1f;
            padding:20px;
            line-height: 1.6;
        }
        .container { max-width:1200px; margin:0 auto }
        header { 
            display:flex; 
            justify-content:space-between; 
            align-items:center; 
            margin-bottom:40px;
            padding: 0 8px;
        }
        header h1 { 
            font-size:2rem; 
            font-weight:700; 
            margin:0;
            letter-spacing: -0.02em;
        }
        header a { 
            padding:10px 16px; 
            text-decoration:none; 
            background:#0A84FF;
            color:#fff;
            border:none;
            border-radius:8px;
            font-weight:500;
            transition: all 0.2s ease;
            cursor:pointer;
        }
        header a:hover { 
            background:#0071E3;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        header .user-info {
            color: #666;
            font-size: 0.95rem;
        }
        .gallery { 
            display:grid; 
            grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); 
            gap:20px; 
            margin-bottom:40px;
        }
        .photo-card { 
            background:#fff; 
            border-radius:12px; 
            overflow:hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor:pointer;
        }
        .photo-card:hover { 
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
            transform: translateY(-4px);
        }
        .photo-card img { 
            width:100%; 
            height:240px; 
            object-fit:cover; 
            display:block;
        }
        .photo-info { 
            padding:16px;
        }
        .photo-info h3 { 
            margin:0 0 8px 0; 
            font-size:1.05rem;
            font-weight:600;
            color:#1d1d1f;
        }
        .photo-info p { 
            margin:0 0 6px 0; 
            font-size:0.95rem; 
            color:#666;
            line-height: 1.5;
        }
        .photo-info small {
            font-size:0.85rem;
            color:#999;
        }
        .empty-message { 
            text-align:center; 
            padding:60px 20px; 
            color:#999;
            font-size: 1.05rem;
        }
        footer { 
            text-align:center; 
            padding:20px 0; 
            color:#999; 
            font-size:0.9rem;
            border-top: 1px solid #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Photos</h1>
            <div class="header-controls">
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <span class="user-info">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php">Sign Out</a>
                <?php else: ?>
                    <a href="login.php">Admin Panel</a>
                <?php endif; ?>
            </div>
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
                <p>✨ No photos yet</p>
            </div>
        <?php endif; ?>

        <footer>
            <p>&copy; 2026 Photo Gallery</p>
        </footer>
    </div>
</body>
</html>
