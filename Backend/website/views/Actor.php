<?php
include_once '../app/models/Actor.php';
include_once '../app/models/Movie.php';

$actorId = isset($_GET['id']) ? $_GET['id'] : '';

if ($actorId) {
    $actors = new Actor();
    $movies = new Movie();
    $actor = $actors->getActorById($actorId);
    
    if ($actor) {
        $baseImageUrl = "https://image.tmdb.org/t/p/w500";
        $imageUrl = $baseImageUrl . $actor['profile_path'];
        $name = htmlspecialchars($actor['name']);
        $bio = htmlspecialchars($actor['biography']);
        $known_for_departament = htmlspecialchars($actor['known_for_department']);
        $birthday = htmlspecialchars($actor['birthday']);
        $place_of_birth = htmlspecialchars($actor['place_of_birth']);
        $popularity = htmlspecialchars($actor['popularity']);
        $movies = $movies->getMoviesByActorId($actorId); 
    } else {
        echo "Actor not found.";
        exit;
    }
} else {
    echo "No actor specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $name ?></title>
    <link rel="stylesheet" href="styles/styles_actor.css">
    <link rel="stylesheet" href="styles/styles_nav_footer.css">
</head>
<body>
<header>
    <div class="logo">
        <a href="../home.html"><img src="../photos/logo.png.png" alt="logo_nav_bar"></a>
    </div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <div class="nav-bar">
        <ul>
            <li>
                <a href="nominees.html">Nominees</a>
            </li>
            <li>
                <a href="news.html">News</a>
            </li>  
            <li>
                <a href="search.html">Search</a>
            </li>
            <li>
                <a href="../home.html">Home</a>
            </li>
        </ul>
    </div>
</header>
<div class="top_body">
    <div class="left_side">
        <img src="<?= $imageUrl ?>" class="image" alt="actor-photo">
        <div class="overlay">
            <div class="actor_info">
                <h2><?= $name ?></h2>
                <div class="personal_details">
                    <p><strong>Personal details:</strong></p>
                    <p><strong>Known for departament:</strong> <?= $known_for_departament ?></p>
                    <p><strong>Born:</strong> <?= $birthday?> </p>
                    <p><strong>Place of birth:</strong> <?= $place_of_birth ?></p>
                    <p><strong>Popularity:</strong> <?= $popularity ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="right_side">
        <h1><?= $name ?></h1>
        <p><?= $bio ?></p>
    </div>
</div>
<div class="bottom_body">
    <div class="photo_container">
        <button class="scroll-button scroll-left">&#8249;</button>
        <div class="scroll-container">
            <?php foreach ($movies as $movie): ?>
                <img src="<?= $baseImageUrl . $movie['poster_path'] ?>" alt="<?= htmlspecialchars($movie['title']) ?>" width="300" height="400">
            <?php endforeach; ?>
        </div>
        <button class="scroll-button scroll-right">&#8250;</button>
    </div>
</div>
<footer>
    <div class="footer-left">
        <img src="../photos/mini_logo.png" alt="Logo">
    </div>
    <a class="admin" href="login.html">Admin Login</a>
    <div class="footer-right">
        <a href="https://www.facebook.com"><img src="../photos/facebook-icon.png" alt="Facebook"></a>
        <a href="https://www.instagram.com"><img src="../photos/instagram-icon.png" alt="Instagram"></a>
        <a href="https://www.tiktok.com"><img src="../photos/tiktok-icon.png" alt="TikTok"></a>
    </div>
</footer>
</body>
</html>
