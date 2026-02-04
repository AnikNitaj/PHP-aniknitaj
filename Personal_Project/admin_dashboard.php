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
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Arial,Helvetica,sans-serif;background:#fff;color:#111}
        .container{max-width:980px;margin:0 auto;padding:16px}
        header{padding:8px 0;display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
        header h1{font-size:1.25rem;margin:0}
        .btn-group{display:flex;gap:8px}
        a.btn,button{padding:8px 10px;border:1px solid #ccc;background:#f8f8f8;color:inherit;text-decoration:none;border-radius:4px;cursor:pointer}
        .table-container{border:1px solid #e6e6e6;background:#fff;border-radius:4px;overflow:auto}
        table{width:100%;border-collapse:collapse}
        th{padding:10px;text-align:left;border-bottom:1px solid #e6e6e6;font-weight:600}
        td{padding:10px;border-bottom:1px solid #f0f0f0}
        tr:hover{background:#fafafa}
        .photo-thumbnail{width:60px;height:60px;object-fit:cover}
        .action-buttons{display:flex;gap:6px}
        .empty-message{text-align:center;padding:30px;color:#666}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Dashboard</h1>
            <div class="btn-group">
                <span class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="admin_add_photo.php" class="btn btn-primary">+ Add Photo</a>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </header>

        <div class="table-container">
            <?php if (count($photos) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($photos as $photo): ?>
                            <tr>
                                <td>
                                    <img src="uploads/<?php echo htmlspecialchars($photo['filename']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" class="photo-thumbnail">
                                </td>
                                <td><?php echo htmlspecialchars($photo['title']); ?></td>
                                <td><?php echo htmlspecialchars(substr($photo['description'], 0, 50)); ?>...</td>
                                <td><?php echo date('M d, Y', strtotime($photo['created_at'])); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="admin_edit_photo.php?id=<?php echo $photo['id']; ?>" class="btn-edit">Edit</a>
                                        <form method="POST" action="admin_delete_photo.php" style="display: inline;">
                                            <input type="hidden" name="id" value="<?php echo $photo['id']; ?>">
                                            <button type="submit" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-message">
                    <p>No photos yet. <a href="admin_add_photo.php" style="color: #667eea;">Add one now</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
