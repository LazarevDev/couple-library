<?php 
$title = "Поиск";

if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $search = urlencode($search);
    header('Location: ../search/'.$search);
}
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
                <input type="text" name="search" class="input" placeholder="Введите название фильма" required>
                <input type="submit" name="submit" class="submit" value="Найти">
            </form>

            <div class="titleSection">
                <h2>
                    <?php 
                        if(!empty($paramTwo)){
                            $paramTwo = urldecode($paramTwo);
                            echo "Поиск: ".$paramTwo;
                        }else{
                            echo "Фильмы";
                        }
                    ?>
                </h2>
            </div>
           
            <?php if($paramTwo): $paramTwo = urldecode($paramTwo); ?>

                <div class="movies">
                    <?php $query = mysqli_query($db, "SELECT * FROM `movies` WHERE `nameRu` LIKE '%".$paramTwo."%'  ORDER BY `year` DESC LIMIT 20");
                        while($row = mysqli_fetch_array($query)){ 
                            $kinopoiskId = $row['kinopoiskId'];
                            ?>
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
                    <?php } ?>
                </div>
            <?php else: ?>
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
                    <?php } ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php require_once('template/footer.php'); ?>
</body>
</html>
