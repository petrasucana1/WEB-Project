<?php
include_once '../app/models/Actor.php';
include_once '../app/models/Movie.php';
include ("components/navbar.html");

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
</head>
<body>
<div class="top_body">
    <div class="left_side">
        <img src="<?= $imageUrl ?>" class="image" alt="actor-photo">
        <div class="overlay">
            <div class="actor_info">
                <h2><?= $name ?></h2>
                <div class="personal_details">
                    <p><strong>Personal details:</strong></p>
                    <p><strong>Known for department:</strong> <?= $known_for_departament ?></p>
                    <p><strong>Born:</strong> <?= $birthday ?> </p>
                    <p><strong>Place of birth:</strong> <?= $place_of_birth ?></p>
                    <p><strong>Popularity:</strong> <?= $popularity ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="right_side">
        <h1><?= $name ?></h1>
        <p><?= substr($bio, 0, strpos($bio, '.', strpos($bio, '.', strpos($bio, '.') + 1) + 1) + 1) ?></p>
        <button id="read-more-button">Read More</button>
        <p id="full-bio" style="display: none;"><?= $bio ?></p>
    </div>
</div>

<div class="bottom_body">
    <div class="photo_container">
        <button class="scroll-button scroll-left">&#8249;</button>
        <div class="scroll-outer">
            <div class="scroll-container">
                <?php foreach ($movies as $movie): ?>
                    <img src="<?= $baseImageUrl . $movie['poster_path'] ?>" alt="<?= htmlspecialchars($movie['title']) ?>" width="300" height="400">
                <?php endforeach; ?>
            </div>
        </div>
        <button class="scroll-button scroll-right">&#8250;</button>
    </div>
</div>

<?php
include ("components/footer.html");
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const scrollLeftButton = document.querySelector(".scroll-left");
        const scrollRightButton = document.querySelector(".scroll-right");
        const scrollOuter = document.querySelector(".scroll-outer");

        scrollLeftButton.addEventListener("click", function() {
            scrollOuter.scrollBy({
                left: -300, 
                behavior: "smooth"
            });
        });

        scrollRightButton.addEventListener("click", function() {
            scrollOuter.scrollBy({
                left: 300, 
                behavior: "smooth"
            });
        });

        const readMoreButton = document.getElementById('read-more-button');
        const fullBio = document.getElementById('full-bio');

        readMoreButton.addEventListener('click', function() {
            fullBio.style.display = 'block';
            readMoreButton.style.display = 'none';
        });
    });
</script>
</body>
</html>
