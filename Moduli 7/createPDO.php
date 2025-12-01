<?php

$host = 'localhost';
$user = 'root';
$pass = '';

try{
    $conn = new PDO("mysql:host=$host", $user, $pass);
    $sql = "create database testdb1";
    $conn->exec($sql);
   
    echo "Database created";
}catch (Exception $e){
    echo "database not created, something went wrong";
}
?>

