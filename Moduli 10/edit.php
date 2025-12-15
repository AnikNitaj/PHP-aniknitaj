<?php
include_once ('config.php');
$id=$_GET['id'];

$sql="SELECT * FROM users WHERE id=:id";

$prep=$conn->prepare($sql);
$prep->bindParam(':id',$id);
$prep->execute();
$data=$prep->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <form action="update.php?id=<?= $user['id'];?>" method="post">
        <input type="text" name="name" value="<?= $user['name'];?>" required>
        <input type="text" name="username" value="<?= $user['username'];?>" required>
        <input type="email" name="email" value="<?= $user['email'];?>" required>
        <button type="submit" name="submit">Update User</button>
    </form>
    <a href="dashbord.php">Back to Dashboard</a>
</body>
</html>