<?php 
require_once('../require/db.php');

$loginCookie = $_COOKIE['login'];

$queryUser = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$loginCookie'");
$resultUser = mysqli_fetch_array($queryUser);

$userId = $resultUser['id'];
$partnerId = $_POST['id'];

if($resultUser['partner_id'] == 0){
    $partnerId = $_POST['id'];
    echo "subscribe";
}else{
    if($resultUser['partner_id'] == $partnerId){
        $partnerId = 0;
        echo "unsubscribe";
    }else{
        echo "subscribe";
    }    
}

$queryUpdate = mysqli_query($db, "UPDATE `users` SET `partner_id` = '$partnerId' WHERE `id` = '$userId'");

?>
