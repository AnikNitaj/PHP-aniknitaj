<?php
include_once('config.php');

id(iiset($post['submit'])){
    $name=$_POST['name'];
    $username=$_POST['username'];
    $email=$_POST['email'];

    $sql="INSERT INTO users(name,username,email) VALUES(:name,:username,:email)";
    $sqlQuery=$conn->prepare($sql);

    $sqlQuery->bindParam(':name',$name);
    $sqlQuery->bindParam(':username',$username);
    $sqlQuery->bindParam(':email',$email);
    $sqlQuery->execute();

    echo "Data saved successfully.";
    header("dashboard.php");
}

    $sql="INSERT INTO users(name,username,email) VALUES(:name,:username,:email)";
    $adduser=$conn->prepare($sql);
    $adduser->bindParam(':name',$name);
    $adduser->bindParam(':username',$username);
    $adduser->bindParam(':email',$email);
    $adduser->execute();

    if($adduser){
        echo "User added successfully.";
    }else{
        echo "Error adding user.";
    }
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
<body>
    <form action="">
        <form action="add.php" method="POST">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="username" placeholder="username">
        <input type="text" name="email" placeholder="email">
        <button type="submit" name="submit">Add User</button>
    </form>
    </body>
    <?php