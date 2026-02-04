<?php
session_start();

$user="root";
$pass="";
$server="localhost";
$dbname="db personal project";

try {
    
    $conn = new PDO("mysql:host=$server;dbname=$dbname",$user,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}


define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');
?>
