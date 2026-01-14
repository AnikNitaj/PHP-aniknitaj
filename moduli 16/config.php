<?php

$userr='root';
$pass='';
$server="localhost";
$dbname='mms';

try{
    $conn=new PDO("mysql:host=$server;dbname=$dbname",$userr,$pass);

}catch(PDOException $e){
    echo "Error: " . $e->getMessage();
}