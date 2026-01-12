<?php
include_once('config.php');
$sql="SELECT * FROM users";
$getUsers=$conn->prepare($sql);
$getUsers->execute();
$users=$getUsers->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
        </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user){
                ?>            
            <tr>
                <td><?= $user['id']; ?></td>
                <td><?= $user['name']; ?></td>
                <td><?= $user['username']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['password']; ?></td>
            </tr>