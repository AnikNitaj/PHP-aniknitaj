<?php
include_once ('config.php');

if (isset($_POST['update'])) {
    $id = $_post['id'];
    $name = $_post['name'];
    $username = $_post['username'];
    $email = $_post['email'];

    $sql = "UPDATE users SET name=:name, username=:username, email=:email WHERE id=:id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: dashbord.php');
}