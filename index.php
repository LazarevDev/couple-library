<?php  
require('require/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
</head>
<body>

    <section>
        <div class="container">
            <div class="movies">
                <?php 
                    $query = mysqli_query($db, "SELECT * FROM `movies` ORDER BY `year` DESC LIMIT 20");
                    while($row = mysqli_fetch_array($query)){ ?>
                    <a href="https://flicksbar.fun/film/<?=$row['kinopoiskId']?>" class="movieItem">
                        <div class="moviePreview">
                            <img src="<?=$row['posterUrlPreview'];?>" alt="">
                        </div>

                        <div class="movieInf">
                            <h2><?=$row['nameRu'];?></h2>
                            <p><?php echo $row['year']." - ".$row['ratingKinopoisk'];?></p>
                            </div>
                            </a>
                    <?php }
                ?>
            </div>
        </div>
    </section>

</body>
</html>