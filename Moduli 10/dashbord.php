<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px 20px;
        }
    </style>
    </head>
    <body>
    <?php
    include_once('config.php');
    $sql="SELECT * FROM users";
    $getusers=$conn->prepare($sql);
    $getusers->execute();
    $users=$getusers->fetchAll();
    ?>
            <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Surname</th>
            <th>Update</th>
            </thead>
        <tbody>
            <?php
            foreach($users as $user){
                ?>
                <tr>
                    <td><?= $user['id'];?></td>
                    <td><?= $user['name'];?></td>
                    <td><?= $user['email'];?></td>
                    <td><?= $user['username'];?></td>
                    <td><a href='delete.php?id=<?= $user['id'];?>'>Delete</a> | <a href='update.php?id=<?= $user['id'];?>'>Update</a></td>
                </tr>              
                <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>


