<?php 
$kinopoiskId = $paramTwo;
$titie = "sad";
$queryMovie = mysqli_query($db, "SELECT * FROM `movies` WHERE `kinopoiskId` = $kinopoiskId");
$resultMovie = mysqli_fetch_array($queryMovie);

if(!$resultMovie){
    die('404');
}

$queryInfo = mysqli_query($db, "SELECT * FROM `movie-information` WHERE `kinopoiskId` = $kinopoiskId");
$resultInfo = mysqli_fetch_array($queryInfo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php foreach($cssAccess as $css): ?>
        <link rel="stylesheet" href="<?=$css?>">
    <?php endforeach; ?>
    
    <title><?=$titie?></title>
</head>
<body>
    <section>
        <div class="sectionContainer">
            <div class="cover">
                <div class="coverMask">
                    <a href="../films" class="back">
                        <svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.00001 17.75C8.80095 17.7509 8.6099 17.6716 8.47001 17.53L0.470011 9.52997C0.177558 9.23715 0.177558 8.76279 0.470011 8.46997L8.47001 0.469969C8.76552 0.19461 9.22602 0.202735 9.51163 0.488347C9.79725 0.773959 9.80537 1.23446 9.53001 1.52997L2.06001 8.99997L9.53001 16.47C9.82246 16.7628 9.82246 17.2372 9.53001 17.53C9.39013 17.6716 9.19908 17.7509 9.00001 17.75Z" fill="white"/>
                        </svg>
                    </a>

                    <div class="text">
                        <h2><?=$resultMovie['nameRu']?></h2>
                        <p>
                            <?php
                                $queryGenres = mysqli_query($db, "SELECT * FROM `genres` WHERE `kinopoiskId` = '$kinopoiskId'");
                                while($rowGenres = mysqli_fetch_array($queryGenres)){
                                    echo $rowGenres['genre'].", ";
                                }
                            ?>
                        </p>
                        <span><?=$resultMovie['year']." г."?></span>

                        <a href="" class="btnMovie">Будем смотреть</a>
                        <a href="" class="btnMovieBefore">Смотреть бесплатно</a>
                    
                        <div class="hr"></div>
                    </div>
                </div>

                <img src="<?=$resultMovie['posterUrl']?>" alt="">
            </div>

            <div class="container">
                <div class="content">
                    <h2>Описание</h2>

                    <p><?=$resultInfo['description'];?></p>

                    <h2>Трейлер</h2>
                </div>
            </div>
        </div>
    </section>
</body>
</html>