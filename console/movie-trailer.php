<?php
require_once('../require/db.php');
require_once('../require/apiKey.php');

$urlItem = null;
$nameItem = null;
$siteItem = null;

$queryMovie = mysqli_query($db, "SELECT * FROM `movies` ORDER BY `id` DESC");
while($row = mysqli_fetch_array($queryMovie)){
    $kinopoiskId = $row['kinopoiskId'];

    $queryTrailer = mysqli_query($db, "SELECT * FROM `movie-trailer` WHERE `kinopoiskId` = '$kinopoiskId'");
    $resultMovie = mysqli_fetch_array($queryTrailer);

    if(empty($resultMovie['kinopoiskId'])){
        $movieId = $kinopoiskId;

        $url = "https://kinopoiskapiunofficial.tech/api/v2.2/films/{$movieId}/videos";
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
        $movieTrailer = json_decode($response, true);

        var_dump($movieTrailer);

        if(!empty($movieTrailer['items'][0]['url'])){
            $urlItem = $movieTrailer['items'][0]['url'];
            $nameItem = $movieTrailer['items'][0]['name'];
            $siteItem = $movieTrailer['items'][0]['site'];
    
            echo $nameItem." \n";
            
            $movieValue = mysqli_query($db, "INSERT INTO `movie-trailer`
            (`site`, `name`, `url`, `kinopoiskId`) 
            VALUES ('$siteItem', '$nameItem', '$urlItem', '$movieId')");
        }
    }
}