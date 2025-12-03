<?php

$HOST = 'localhost';
$db="test";
$USER = 'root';
$PASSWORD = '';

try{
    $pdo=new PDO("mysql:host=$HOST;dbname=$db",$USER,$PASSWORD);
    $sql="CREATE TABLE users (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(50) NOT NULL
    );";

    $pdo->exec($sql);

    echo "Table created successfully";

}catch (Exception $e){
    echo "Connection failed: " . $e->getMessage();
}
?>
