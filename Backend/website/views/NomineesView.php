
<?php
//include_once '../public/index.php';
include_once '../app/models/Nominee.php';
include_once '../app/models/Actor.php';


$selected_year = isset($_GET['year']) ? $_GET['year'] : '2023';

$actors=new Actor();
$nom= new Nominee();
$nominees=$nom->getNomineesByYear($selected_year);


$categories = [
    "FEMALE ACTOR IN A LEADING ROLE" => [],
    "MALE ACTOR IN A LEADING ROLE" => [],
    "FEMALE ACTOR IN A SUPPORTING ROLE" => [],
    "MALE ACTOR IN A SUPPORTING ROLE" => [],
    "FEMALE ACTOR IN A DRAMA SERIES" => [],
    "MALE ACTOR IN A DRAMA SERIES" => [],
    "FEMALE ACTOR IN A COMEDY SERIES" => [],
    "MALE ACTOR IN A COMEDY SERIES" => [],
    "FEMALE ACTOR IN A TELEVISION MOVIE OR LIMITED SERIES" => [],
    "MALE ACTOR IN A TELEVISION MOVIE OR LIMITED SERIES" => []
];

// Populăm categorii cu nominalizările din baza de date sau API
foreach ($nominees as $nominee) {
    $categories[$nominee['Category']][] = $nominee;
}
// Generăm HTML pentru fiecare categorie
foreach ($categories as $category => $nomineesInCategory):
    if (count($nomineesInCategory) > 0): ?>
        <div class="nominee">
            <div class="image">
                <?php
                foreach ($nomineesInCategory as $nominee):
                    if ($nominee['Award'] === 'YES') {
                        $actorName = $nominee['First Name'] . ' ' . $nominee['Last Name'];
                        $actor=$actors->getActorByName($actorName);
                        if($actor){
                            $baseImageUrl = "https://image.tmdb.org/t/p/w500";
                            $imageUrl = $baseImageUrl . $actor['profile_path'];
                            echo "<img src='$imageUrl' alt='Actor Profile Picture'>";
                        }else{ 
                            //DEFAULT ZENDAYA PHOTO
                            $baseImageUrl = "https://image.tmdb.org/t/p/w500";
                            $imageUrl = $baseImageUrl . "/hC2qgP2mdrXZWmKF0WNSlM92Vuz.jpg";
                            echo "<img src='$imageUrl' alt='Actor Profile Picture'>";
                        }
                        break; 
                    }
                endforeach;
                ?>
                            
            </div>
            <div class="text">
                <?php
                // Găsim câștigătorul și îl afișăm în primul rând
                foreach ($nomineesInCategory as $nominee):
                    if ($nominee['Award'] === 'YES'):
                        ?>
                        <div class="actor">
                            <h2>RECIPIENT</h2>
                            <a href="actor.html"><h1><?= htmlspecialchars($nominee['First Name']) . ' ' . htmlspecialchars($nominee['Last Name']) ?></h1></a>
                            <h3><?= htmlspecialchars($nominee['Project']) ?></h3>
                        </div>
                        <hr>
                        <?php
                        break; // Întrerupem bucla după ce am găsit câștigătorul
                    endif;
                endforeach;

                // Afișăm restul nominalizărilor non-câștigătoare
                $nonWinnersCount = 0; // Numărăm câți nominalizați non-câștigători am afișat
                foreach ($nomineesInCategory as $nominee):
                    if ($nominee['Award'] !== 'YES' && $nonWinnersCount < 4): // Afisăm doar non-câștigătorii și maxim 4
                        ?>
                        <div class="actor">
                            <h2><?= htmlspecialchars($nominee['First Name']) . ' ' . htmlspecialchars($nominee['Last Name']) ?></h2>
                            <h3><?= htmlspecialchars($nominee['Project']) ?></h3>
                        </div>
                        <?php
                        $nonWinnersCount++;
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    <?php endif;
endforeach; ?>
