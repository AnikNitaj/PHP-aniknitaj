<?php

include_once('config.php');

if_(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);

    if(empty($name) || empty($email) || empty($username) || empty($password)){
        header('Location: register.php?error=emptyfields');
        else{
            $sql="Select users WHERE username=:username";

            $tempSQL=$conn->prepare($sql);
            $tempSQL->bindParam(':username', $username);
            $tempSQL->execute();

            if($tempSQL->rowCount()>0){
                echo "username exists";
                header('refresh:2; url=register.php');

                if(empty($name)) {
                    echo "Name is required.";
                } elseif(empty($email)) {
                    echo "Email is required.";
                } elseif(empty($username)) {
                    echo "Username is required.";
                } elseif(empty($password)) {
                    echo "Password is required.";
                }

                exit();
            }

            $sql="INSERT INTO users(name, email, username, password) VALUES(:name, :email, :username, :password)";
            $register=$conn->prepare($sql);
            $register->bindParam(':name', $name);
            $register->bindParam(':email', $email);
            $register->bindParam(':username', $username);
            $register->bindParam(':password', $password);


            $register->execute();
            echo"Data saved successfully";
            header('refresh:2; url=dashbord.php');
         
        }
    }
}