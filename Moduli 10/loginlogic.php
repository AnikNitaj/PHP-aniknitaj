<?php


include_once ('config.php');
session_start();

if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $email=$_POST['email'];

    if($empty($username) || empty($password) || empty($email)){
        echo "All fields are required.";
        header("Location:login.php");
        
    } else {
        $sql="SELECT * FROM users WHERE username=:username";
        $insertsql=$conn->prepare($sql);
        $insertsql->bindParam(':username',$username);
        $insertsql->execute();

        $user=$insertsql->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password,$user['password'])){
            session_start();
            $_SESSION['user_id']=$user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Invalid username or password.";
            header("Location:login.php");
            exit;

            $data=$insertsql->fetch();
            if(password_verify($password,$data['password'])){
                session_start();
                $_SESSION['user_id']=$data['id'];
                header("Location:dashboard.php");
                exit;
            } else {
                echo "Invalid username or password.";
                header("Location:login.php");
                exit;
            }
        }
    }

    $sql="UPDATE users SET name=:name, username=:username, email=:email WHERE id=:id";

    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':name',$name);
    $stmt->bindParam(':username',$username);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    header('Location: dashboard.php');
}