<?php 
require_once('../require/db.php');

// 98c041f7-28d2-4412-880a-fe2621e3b557
// f5bd3a8d-6669-4038-8bad-54ad15b68b11

$orders = ['NUM_VOTE', 'YEAR', 'RATING'];
$dates = ['1998', '1999'];

for ($page=1; $page < 6; $page++) { 
    foreach($orders as $order){
        foreach($dates as $date){

            // echo $page." - ".$date." - ".$order;
            $url = 'https://kinopoiskapiunofficial.tech/api/v2.2/films?order='.$order.'&type=FILM&ratingFrom=0&ratingTo=10&yearFrom='.$date.'&yearTo='.$date.'&page='.$page;
            $headers = array(
                'accept: application/json',
                'X-API-KEY: f5bd3a8d-6669-4038-8bad-54ad15b68b11'
            );
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Выполняем запрос
            $response = curl_exec($ch);
            $response = json_decode($response);
            curl_close($ch);
        
            
            $movies = $response;
        
            if(empty($movies)){
                echo "Скрипт завершился";
                break;
            }
        
            // print_r('<pre>');
            foreach($movies as $movie){
                if(is_array($movie)){
                    foreach($movie as $movieInfo){
                        
                        echo $movieInfo->nameRu." \n";
                        $query = mysqli_query($db, "SELECT * FROM `movies` WHERE `kinopoiskId` = '$movieInfo->kinopoiskId'");
                        $result = mysqli_fetch_array($query);
                        if(empty($result['kinopoiskId'])){
                            if($movieInfo->nameRu){
                                echo "Название: ".$movieInfo->nameRu."\n";
                                // echo "kinopoiskId: ".$movieInfo->kinopoiskId."<br>";
                                // echo "year: ".$movieInfo->year."<br>";
                                // echo "type: ".$movieInfo->type."<br>";
                                // echo "posterUrl: ".$movieInfo->posterUrl."<br>";
                                // echo "posterUrlPreview: ".$movieInfo->posterUrlPreview."<br><br>";
                                $nameRu = mysqli_real_escape_string($db, $movieInfo->nameRu);
                                $movieValue = mysqli_query($db, "INSERT INTO `movies` 
                                (`nameRu`, `kinopoiskId`, `year`, `type`, `posterUrl`, `posterUrlPreview`, `ratingKinopoisk`) VALUES 
                                ('$nameRu', '$movieInfo->kinopoiskId', '$movieInfo->year', '$movieInfo->type', '$movieInfo->posterUrl', '$movieInfo->posterUrlPreview', '$movieInfo->ratingKinopoisk')"); 
            
                                foreach($movieInfo->countries as $country){
                                    // echo "Страны: ".$country->country.", ";
                                
                                    $countryValue = mysqli_query($db, "INSERT INTO `countries` 
                                    (`kinopoiskId`, `country`) VALUES 
                                    ('$movieInfo->kinopoiskId', '$country->country')"); 
                    
                                }
            
            
                                foreach($movieInfo->genres as $genre){
                                    // echo "Жанры: ".$genre->genre.", ";
                                
                                    $countryValue = mysqli_query($db, "INSERT INTO `genres` 
                                    (`kinopoiskId`, `genre`) VALUES 
                                    ('$movieInfo->kinopoiskId', '$genre->genre')");
                                }
                                echo "\n";
            
                                // echo "<br>";
                                // echo "<br>";
            
                            }
                        }
                    }
                }
            }
            sleep(1);
        }
    }
}