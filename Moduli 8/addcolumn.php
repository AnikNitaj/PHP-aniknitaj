<?php
$host='localhost';
$db='test';
$user='root';
$password='';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    // $sql = "ALTER TABLE users ADD COLUMN email VARCHAR(255);";
    $sql = "ALTER TABLE users ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;";
    $pdo->exec($sql);
    echo "Column added successfully";


}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();

}