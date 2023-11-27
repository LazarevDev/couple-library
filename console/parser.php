<?php 
require_once('../require/db.php');

$page = 0;
while(true){
    $page++;

    echo $page;

        $url = 'https://kinopoiskapiunofficial.tech/api/v2.2/films?order=RATING&type=FILM&ratingFrom=0&ratingTo=10&yearFrom=2013&yearTo=2013&page='.$page;
        $headers = array(
            'accept: application/json',
            'X-API-KEY: b917d229-5d11-4bb2-902b-bdd90ba2d7f4'
        );
    
        // Создаем cURL-сессию
        $ch = curl_init();
        // Устанавливаем URL-адрес и другие параметры запроса
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Выполняем запрос
        $response = curl_exec($ch);
        $response = json_decode($response);

        // Закрываем cURL-сессию
        curl_close($ch);
    
        // Возвращаем ответ
    
    // Пример использования API-запроса
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
    
                        $movieValue = mysqli_query($db, "INSERT INTO `movies` 
                        (`nameRu`, `kinopoiskId`, `year`, `type`, `posterUrl`, `posterUrlPreview`) VALUES 
                        ('$movieInfo->nameRu', '$movieInfo->kinopoiskId', '$movieInfo->year', '$movieInfo->type', '$movieInfo->posterUrl', '$movieInfo->posterUrlPreview')"); 
    
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

    sleep(5);

}