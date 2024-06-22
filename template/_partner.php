<?php 
$loginCookie = $_COOKIE['login'];

$queryUserCheck = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$loginCookie'");
$resultUserCheck = mysqli_fetch_array($queryUserCheck);

if($resultUserCheck['partner_id'] !== 0){
    $my_id = $resultUserCheck['id'];
    $id_partner = $resultUserCheck['partner_id'];

    $queryUserCheckTwo = mysqli_query($db, "SELECT * FROM `users` WHERE `id` = '$id_partner'");
    $resultUserCheckTwo = mysqli_fetch_array($queryUserCheckTwo);

    if(!empty($resultUserCheckTwo['partner_id']) == $my_id){




?>

        <a href="#" class="partnerBlock">
            <div class="partnerImg"></div>

            <div class="partnerText">
                <h2>Имя Фамилия</h2>
                <p>Перейти в профиль</p>
            </div>
        </a>

<? 
    } 
}
 ?>