<?php

function getPersonsInfo($page) {
    $bearer_token="eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJjNjYxMTkxNzA5NDBjMGVlNjczOTJhMjk5ZDA0Mzg3MyIsInN1YiI6IjY2NDhkMjZmZWE4ZTg1ODU2ZmYyNDJkYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.-qGbUifCD2OBR3K4HM_gWzsCvflw6Er559SgwL7KoYc";
    $url = "https://api.themoviedb.org/3/person/popular?page=" . $page;
    
    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
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
    // Parcurge fiecare pagină de rezultate
    for ($page = 1; $page <= $totalPages; $page++) {
        // Obține informațiile despre persoanele de pe pagina curentă
        $personsInfo = getPersonsInfo($page);

        // Parcurge lista de rezultate de pe pagina curentă
        foreach ($personsInfo['results'] as $result) {
            // Verifică dacă numele actorului corespunde cu numele căutat
            if ($result['name'] === $actorName) {
                // Returnează informațiile despre actor dacă a fost găsit
                return $result;
            }
        }
    }

    // Dacă nu s-a găsit actorul în nicio pagină, returnează null sau poți gestiona cum dorești
    return null;
}

function displayImage($posterPath) {
    // Adresa de bază a imaginilor din API-ul The Movie Database
    $baseImageUrl = "https://image.tmdb.org/t/p/w500";

    // Construiește URL-ul complet al imaginii
    $imageUrl = $baseImageUrl . $posterPath;

    // Afisează imaginea folosind eticheta <img>
    echo "<img src='$imageUrl' alt='Movie Poster'>";
}



// Exemplu de utilizare:
$actorName = "Florence Pugh"; // Numele actorului căutat
$personsInfo = getPersonsInfo(1);
$totalPages = $personsInfo['total_pages'];
$actorInfo = searchActorByName($actorName, $totalPages);

if ($actorInfo) {
    // Dacă s-a găsit actorul, afișează informațiile despre acesta
    print_r($actorInfo);
} else {
    // Dacă nu s-a găsit actorul, afișează un mesaj corespunzător
    echo "Nu s-a găsit niciun actor cu numele '$actorName'.";
}


// Exemplu de utilizare:
$posterPath = $actorInfo['profile_path']; // Poster path-ul din datele obținute de la API

// Afișează imaginea
displayImage($posterPath);

?>