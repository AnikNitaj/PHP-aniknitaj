<?php
include 'config.php';


if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;

    
    $stmt = $conn->prepare("SELECT filename FROM photos WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($photo) {
        
        $file_path = 'uploads/' . $photo['filename'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        
        $stmt = $conn->prepare("DELETE FROM photos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

header('Location: admin_dashboard.php');
exit();
?>
