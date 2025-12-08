<?php

$user="root";
$pass="";
$server="localhost";
$dbname="testdb1";

try{

    $con=new PDO("mysql:host=$server;dbname=$dbname",$user,$pass);
}catch(PDOException $e){
    echo "Error:" .$e->getMessage();

}
