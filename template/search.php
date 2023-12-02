<?php 
$title = "Поиск";

if(isset($_POST['submit'])){
    $search = $_POST['search'];
    $search = urlencode($search);
    header('Location: ../search/'.$search);
}

$where = "ORDER BY `year` DESC LIMIT 40";
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
           
            <?php if($paramTwo): 
                $paramTwo = urldecode($paramTwo); 
                $where = "WHERE `nameRu` LIKE '%".$paramTwo."%' ORDER BY `year` DESC";
                
                ?>

                <div class="movies">
                    <?php require_once('_movies.php'); ?>
                </div>
            <?php else: ?>
                <div class="movies">
                    <?php require_once('_movies.php'); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php require_once('template/footer.php'); ?>
</body>
</html>
