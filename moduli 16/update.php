<?php

include_once('config.php');

if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $movie_name = $_POST['movie_name'];
    $movie_description = $_POST['movie_description'];
    $movie_quality = $_POST['movie_quality'];
    $movie_rating = $_POST['movie_rating'];
    $movie_image = $_POST['movie_image'];

    $sql ="UPDATE movies SET id=:id, movie_name=:movie_name, movie_description=:movie_description, movie_quality=:movie_quality, movie_rating=:movie_rating, movie_image=:movie_image WHERE id=:id";


    $prep=$conn->prepare($sql);
    $prep->bindParam(':id', $id);
    $prep->bindParam(':movie_name', $movie_name);
    $prep->bindParam(':movie_description', $movie_description);
    $prep->bindParam(':movie_quality', $movie_quality);
    $prep->bindParam(':movie_rating', $movie_rating);
    $prep->bindParam(':movie_image', $movie_image);
    $prep->execute();

    header("Location: listmovies.php");
}