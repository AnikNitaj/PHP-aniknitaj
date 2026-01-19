<?php

include_once('config.php');

if(isset($_POST['submit'])){
    $movie_name=$_POST['movie_name'];
    $movie_description=$_POST['movie_description'];
    $movie_quality=$_POST['movie_quality'];
    $movie_rating=$_POST['movie_rating'];
    $movie_image=$_POST['movie_image'];

    $sql="INSERT INTO movies(movie_name,movie_description,movie_quality,movie_rating,movie_image) VALUES
    (:movie_name,:movie_description,:movie_quality,:movie_rating,:movie_image)";
     $insertSQL=$conn->prepare($sql);

    $insertSQL->bindParam(':movie_name',$movie_name);
    $insertSQL->bindParam(':movie_description',$movie_description);
    $insertSQL->bindParam(':movie_quality',$movie_quality);
    $insertSQL->bindParam(':movie_rating',$movie_rating);
    $insertSQL->bindParam(':movie_image',$movie_image);

    $insertMovie->execute();

    header('Location:listmovies.php');
}

