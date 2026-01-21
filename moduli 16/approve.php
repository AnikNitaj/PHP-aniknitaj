<?php

include_once('config.php');

$id=$_GET['id'];

$sql="UPDATE bookings SET is_approved=1 WHERE id=:id";

$prep=$conn->prepare($sql);
$prep->bindParam(':id', $id);
$prep->execute();
header("Location: list_movies.php");