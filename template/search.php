<?php 
$title = "Поиск";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php foreach($cssAccess as $css): ?>
        <link rel="stylesheet" href="<?=$css?>">
    <?php endforeach; ?>
    
    <title><?=$title?></title>
</head>
<body>
    <header>
        <div class="container">
            <div class="headerTitle"><h2>Поиск</h2></div>
        </div>
    </header>

    <section>
        <div class="container">
            <form method="POST" class="searchForm">
                <input type="text" class="input" placeholder="Введите название фильма">
                <input type="submit" class="submit" value="Найти">
            </form>

            <div class="titleSection">
                <h2>Фильмы</h2>
            </div>
            
            <div class="movies">
                <?php 
                    $query = mysqli_query($db, "SELECT * FROM `movies` ORDER BY `year` DESC LIMIT 20");
                    while($row = mysqli_fetch_array($query)){ 
                        $kinopoiskId = $row['kinopoiskId'];
                        ?>
                    <!-- <a href="https://flicksbar.fun/film/<?=$row['kinopoiskId']?>" class="movieItem"> -->
                    <div class="movieItem">
                        <a href="film/<?=$row['kinopoiskId']?>" class="moviePreview">
                            <span class="rating"><?=$row['ratingKinopoisk']?></span>
    
                            <div class="genreMask"><p>
                                <?php 
                                $queryGenres = mysqli_query($db, "SELECT * FROM `genres` WHERE `kinopoiskId` = '$kinopoiskId'"); 
                                while($rowGenre = mysqli_fetch_array($queryGenres)){
                                    echo $rowGenre['genre'].", ";
                                }
                                ?></p>
                            </div>

                            <img src="<?=$row['posterUrlPreview'];?>" alt="">
                        </a>

                        <div class="movieInfo">
                            <a href="" class="btnView">Будем смотреть</a>
                            <h2><?=$row['nameRu']?></h2>
                            <p><?=$row['year']?></p>
                        </div>
                    </div>
                    <?php }
                ?>
            </div>
        </div>
    </section>

    <?php require_once('template/footer.php'); ?>
</body>
</html>
