<?php 
$title = "Профиль";

// данные о пользователи 

$loginCookie = $_COOKIE['login'];

if(!empty($paramTwo)){
    $queryUser = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$paramTwo'");
    $resultUser = mysqli_fetch_array($queryUser);

    if(!$resultUser['login']){
        die('404');
    }
}elseif(!empty($paramOne)){
    $queryUser = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$loginCookie'");
    $resultUser = mysqli_fetch_array($queryUser);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <?php foreach($cssAccess as $css): ?>
        <link rel="stylesheet" href="<?=$css?>">
    <?php endforeach; ?>
    
    <title><?=$title?></title>
</head>
<body>
    <header>
        <div class="container">
            <div class="headerTitle"><h2>Профиль</h2></div>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="center">
                <div class="profileInformation">
                    <div class="profileScore">
                        <h3>13</h3>
                        <p>Мои закладки</p>
                    </div>

                    <div class="profilePhoto">
                        <?php if($resultUser['login'] == $loginCookie){ ?>
                            <form method="POST" action="include/upload-ava.php" class="formProfile" enctype="multipart/form-data">
                                <input type="file" name="ava" id="fileAva" onchange="this.form.submit ()"> 
                                <label for="fileAva" class="avaBtn"></label>
                            </form>
                        <?php } ?>
                        <img src="../img/<?php if($resultUser['ava'] == null){ echo 'elements/profile-ava.png'; }else{ echo 'ava-user/'.$resultQueryProfile['login'].'/'.$resultQueryProfile['ava']; } ?>" alt="">
                    </div>

                    <div class="profileScore">
                        <h3>43</h3>
                        <p>Общие закладки</p>
                    </div>
                </div>
            </div>

            <div class="profileName">
                <h2><?=$resultUser['name']." ".$resultUser['lastname']?></h2>
                <p>@<?=$resultUser['login']?></p>
            </div>

            <!-- <div class="partnersContainer">
                <a href="#" class="partnerBlock">
                    <div class="partnerImg"></div>

                    <div class="partnerText">
                        <h2>Имя Фамилия</h2>
                        <p>Перейти в профиль</p>
                    </div>
                </a>
            </div> -->

            <div class="center">

                <?php if($resultUser['login'] == $loginCookie): ?>
                    <a class="mobileEditProfile" href="include/edit.php">Редактировать профиль</a>
                <? endif; ?>
            </div>
            
            <div class="center">
                <div class="profileMenu">
                    <button class="btnMenu btnOne">Мои закладки</button>
                    <button class="btnMenu btnTwo">Общие закладки</button>
                </div>
            </div>

            <div class="profileContent">
                <div class="oneContent">
                1
                </div>

                <div class="twoContent">
                 2
                </div>
            </div>
        </div>
    </section>

    <?php require_once('template/footer.php'); ?>
    <script src="../js/profile-menu.js"></script>
</body>
</html>
