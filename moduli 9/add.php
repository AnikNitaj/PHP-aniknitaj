<?php

include_once ('configurator.php');

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (name, username, email) VALUES (:name, :username, :email)";
    $sqlQuery=$conn->prepare($sql);
    $sqlQuery->bindParam(':name', $name);
    $sqlQuery->bindParam(':username', $username);
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->errorInfo()[2];
    }
} else {
    echo "Form not submitted properly.";
}