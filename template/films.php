<?php 
$title = "Популярные фильмы";

// данные о пользователи 

$loginCookie = $_COOKIE['login'];
$queryUser = mysqli_query($db, "SELECT * FROM `users` WHERE `login` = '$loginCookie'");
$resultUser = mysqli_fetch_array($queryUser);


// Фильмы

$perPage = 10;

$query = mysqli_query($db, "SELECT COUNT(*) as `total` FROM `movies`");
$totalRecords = mysqli_fetch_array($query)['total'];

$totalPages = ceil($totalRecords / $perPage);
$currentPage = isset($paramTwo) ? $paramTwo : 1;

$offset = ($currentPage - 1) * $perPage;


$where = "ORDER BY `year` DESC LIMIT {$offset}, {$perPage}";
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
            <div class="headerTitle"><h2>Привет, <?=$resultUser['name']?></h2></div>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="partnersContainer">
                <a href="#" class="partnerBlock">
                    <div class="partnerImg"></div>

                    <div class="partnerText">
                        <h2>Имя Фамилия</h2>
                        <p>Перейти в профиль</p>
                    </div>
                </a>
            </div>

            <div class="titleSection">
                <h2>Популярное</h2>
            </div>
            
            <div class="movies">
                <?php require_once('_movies.php'); ?>
            </div>

            <div class="pagination">
                <?php 
                $pagesToShow = 5;

                $startPage = max(1, $currentPage - floor($pagesToShow / 2));
                $endPage = min($startPage + $pagesToShow - 1, $totalPages);

                for ($page = $startPage; $page <= $endPage; $page++) {
                    echo '<a href="../films/'.$page.'">'.$page.'</a>';
                }
                ?>
            </div>
        </div>
    </section>

    <?php require_once('template/footer.php'); ?>
</body>
</html>
