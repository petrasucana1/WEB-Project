<?php

function getPersonsInfo($page) {
    $bearer_token="eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjNjYxMTkxNzA5NDBjMGVlNjczOTJhMjk5ZDA0Mzg3MyIsInN1YiI6IjY2NDhkMjZmZWE4ZTg1ODU2ZmYyNDJkYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.-qGbUifCD2OBR3K4HM_gWzsCvflw6Er559SgwL7KoYc";
    $url = "https://api.themoviedb.org/3/person/popular?page=" . $page;
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $bearer_token
    ));


    $response = curl_exec($curl);

    if($response === false) {
        echo 'Curl error: ' . curl_error($curl);
    } else {
        $data = json_decode($response, true);
    }

    curl_close($curl);

    return $data;


}

function searchActorByName($actorName, $totalPages) {
    
    set_time_limit(300);
    for ($page = 1; $page <= $totalPages; $page++) {
        $personsInfo = getPersonsInfo($page);

        foreach ($personsInfo['results'] as $result) {
            if ($result['name'] === $actorName) {
                return $result;
            }
        }
    }
    return null;
}

function displayImage($posterPath) {
    $baseImageUrl = "https://image.tmdb.org/t/p/w500";
    $imageUrl = $baseImageUrl . $posterPath;
    echo "<img src='$imageUrl' alt='Actor Profile Picture'>";
}

?>