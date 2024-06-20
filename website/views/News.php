<?php
include_once '../app/models/News.php';

// Function to handle JSON response for AJAX
function handleAjaxRequest() {
    $newsObj = new News();
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $newsList = $newsObj->getNewsWithPagination($offset, $limit);
    echo json_encode($newsList);
    exit;
}

// Check if this is an AJAX request
if (isset($_GET['offset']) && isset($_GET['limit'])) {
    handleAjaxRequest();
}

// Initial page load
include ("components/navbar.html");

$newsObj = new News();
$initialNewsList = $newsObj->getNewsWithPagination(0, 20);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="styles/styles_news.css">
</head>
<body>
    <section class="news">
        <div class="table">
            <table id="news-table">
                <tr>
                    <th class="news-header">NEWS</th>
                    <th class="date-header">DATE</th>
                </tr>
                <?php
                if ($initialNewsList) {
                    foreach ($initialNewsList as $news) {
                        echo '<tr>';
                        echo '<td><a href="' . htmlspecialchars($news['Link']) . '" target="_blank"><h2>' . htmlspecialchars($news['Title']) . '</h2></a></td>';
                        echo '<td><h3>' . htmlspecialchars($news['Date']) . '</h3></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No news available.</td></tr>';
                }
                ?>
            </table>
        </div>
        <button class="more_news" id="more-news-button"><span>More NEWS</span></button>
    </section>
    <script>
        document.getElementById('more-news-button').addEventListener('click', function() {
            let offset = document.querySelectorAll('#news-table tr').length - 1; // Minus 1 for the header row
            let limit = 10;
            console.log(`Fetching more news with offset=${offset} and limit=${limit}`); // Debugging line
            fetch(`news.php?offset=${offset}&limit=${limit}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Received data:', data); // Debugging line
                    if (data.length > 0) {
                        const newsTable = document.getElementById('news-table');
                        data.forEach(news => {
                            let row = document.createElement('tr');
                            row.innerHTML = `
                                <td><a href="${news.Link}" target="_blank"><h2>${news.Title}</h2></a></td>
                                <td><h3>${news.Date}</h3></td>
                            `;
                            newsTable.appendChild(row);
                        });
                    } else {
                        document.getElementById('more-news-button').disabled = true;
                        document.getElementById('more-news-button').innerText = 'No more news';
                    }
                })
                .catch(error => console.error('Error fetching more news:', error)); // Debugging line
        });
    </script>
</body>
</html>
<?php
include ("components/footer.html");
?>
