<?php
require_once('../require/db.php');
$loginCookie = $_COOKIE['login']; 
$passwordCookie = $_COOKIE['password']; 

$query = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$loginCookie' AND `password` = '$passwordCookie'"); 
$result = mysqli_fetch_array($query);

$id = $_POST['id'];
$user_id = $result['id'];

$loginCookie = $_COOKIE['login'];

$queryFavourite = mysqli_query($db, "SELECT * FROM `favourites` 
WHERE `movie_id` = '$id' AND `user_id` = '$user_id'");
$resultFavourite= mysqli_fetch_array($queryFavourite);

if(empty($resultFavourite['movie_id'])){
    $queryAdd = mysqli_query($db, "INSERT INTO `favourites` (movie_id, user_id) VALUES ('$id', '$user_id')");
    echo "success";
}else{
    $queryDelete = mysqli_query($db, "DELETE FROM `favourites` WHERE `movie_id` = '$id' AND `user_id` = '$user_id'");
    echo "removed";
}


?>