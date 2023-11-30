<?php 
require_once('../require/db.php');
require_once('../require/apiKey.php');

$description = NULL;
$slogan = NULL;
$shortDescription = NULL;

$queryMovie = mysqli_query($db, "SELECT * FROM `movies` ORDER BY `id` DESC");
while($row = mysqli_fetch_array($queryMovie)){
    $kinopoiskId = $row['kinopoiskId'];

    $queryInformation = mysqli_query($db, "SELECT * FROM `movie-information` WHERE `kinopoiskId` = '$kinopoiskId'");
    $resultMovie = mysqli_fetch_array($queryInformation);

    if(empty($resultMovie['kinopoiskId'])){

        $movieId = $kinopoiskId;

        $url = "https://kinopoiskapiunofficial.tech/api/v2.2/films/{$movieId}";
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                "X-API-KEY: {$apiKey}"
            ]
        ]);
        
        $response = curl_exec($curl);
        curl_close($curl);
        $movieInfo = json_decode($response, true);

        if(empty($movieInfo['nameRu'])){
            echo "Лимит исчерпан";
            break;
        }
        
        echo "Название: " . $movieInfo['nameRu'] . "\n\n";
        if(!empty($movieInfo['description'])) $description = mysqli_real_escape_string($db, $movieInfo['description']);
        if(!empty($movieInfo['slogan'])) $slogan = mysqli_real_escape_string($db, $movieInfo['slogan']);
        if(!empty($movieInfo['shortDescription'])) $shortDescription = mysqli_real_escape_string($db, $movieInfo['shortDescription']);

        $movieValue = mysqli_query($db, "INSERT INTO `movie-information`
        (`description`, `kinopoiskId`, `slogan`, `shortDescription`) 
        VALUES ('$description', '$kinopoiskId', '$slogan', '$shortDescription')");

    }
}

?>