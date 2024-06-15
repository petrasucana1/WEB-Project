<?php
    include ("html/navbar.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="styles/styles_search.css">
    <link rel="stylesheet" href="styles/styles_nav_footer.css">
</head>
<body>
 

<div class="search-container">
    <form method="POST" id="search-form">
        <input type="text" name="search" id="search-bar" placeholder="Search..." class="search-bar">
        <button type="submit" id="search-button" class="advanced-search-button">Search</button>
    </form>
</div>

<div class="results-container">
    <table id="results-table" class="results-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search'])) {
                require_once '../app/models/Actor.php';

                $searchString = $_POST['search'];
                $modelActor = new Actor();
                $results = $modelActor->getActorByString($searchString);

                if ($results) {
                    foreach ($results as $actor) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($actor['name']) . "</td>";
                        echo "<td>
                            <form method='GET' action='/views/Actor.php'>
                                <input type='hidden' name='id' value='" . urlencode($actor['id']) . "'>
                                <button type='submit'>View Details</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No results found</td></tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php
    include ("html/footer.html");
?>
