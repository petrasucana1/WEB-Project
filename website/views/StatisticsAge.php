<?php
include ("components/navbar.html");

include_once '../app/models/Actor.php';
$actor = new Actor();
$actors = $actor->getAllActors(); 
$genZCount = 0;
$millennialsCount = 0;
$genXCount = 0;
$boomers2Count = 0;
$boomers1Count = 0;
$postWarCount = 0;
$ww2Count = 0;
$after2012Count = 0;

foreach ($actors as $actor) {
    $birthYear = (int)date('Y', strtotime($actor['birthday']));
    
    if ($birthYear >= 1997 && $birthYear <= 2012) {
        $genZCount++;
    } elseif ($birthYear >= 1981 && $birthYear <= 1996) {
        $millennialsCount++;
    } elseif ($birthYear >= 1965 && $birthYear <= 1980) {
        $genXCount++;
    } elseif ($birthYear >= 1955 && $birthYear <= 1964) {
        $boomers2Count++;
    } elseif ($birthYear >= 1946 && $birthYear <= 1954) {
        $boomers1Count++;
    } elseif ($birthYear >= 1928 && $birthYear <= 1945) {
        $postWarCount++;
    } elseif ($birthYear >= 1922 && $birthYear <= 1927) {
        $ww2Count++;
    } elseif ($birthYear > 2012) {
        $after2012Count++;
    }
}

$totalActors = count($actors);
$genZPercentage = round(($genZCount / $totalActors) * 100, 2);
$millennialsPercentage = round(($millennialsCount / $totalActors) * 100, 2);
$genXPercentage = round(($genXCount / $totalActors) * 100, 2);
$boomers2Percentage = round(($boomers2Count / $totalActors) * 100, 2);
$boomers1Percentage = round(($boomers1Count / $totalActors) * 100, 2);
$postWarPercentage = round(($postWarCount / $totalActors) * 100, 2);
$ww2Percentage = round(($ww2Count / $totalActors) * 100, 2);
$after2012Percentage = round(($after2012Count / $totalActors) * 100, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribuție în generații</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
      
        #chartContainer {
            width: 100%;
            max-width: 800px; 
            height: 600px;
            margin: auto;
        }
        .export-buttons {
            text-align: center;
            margin-top: 20px; 
            margin-bottom: 30px;
        }
        .export-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            cursor: pointer;
        }
        .export-buttons button:hover {
        background-color: grey;
        }

        .description{
            margin:0 30px 30px 30px;
        }
    </style>
</head>
<body>
    <div id="chartContainer"></div>
    <div class="description">The page features a chart illustrating the distribution of actors across generations.Each category shows the percentage of actors born within specific year ranges. The chart visually represents these generational distributions, providing insights into the demographic composition of actors in the dataset. The page includes interactive features for resizing the chart and exporting data in CSV format, enhancing usability and data accessibility.</div>
    <div class="export-buttons">
        <button onclick="exportToCSV()">Export CSV</button>
    </div>

    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            const data = google.visualization.arrayToDataTable([
                ['Categorie', 'Procent'],
                ['Gen Z (1997-2012)', <?php echo $genZPercentage; ?>],
                ['Millennials (1981-1996)', <?php echo $millennialsPercentage; ?>],
                ['Gen X (1965-1980)', <?php echo $genXPercentage; ?>],
                ['Boomers II (1955-1964)', <?php echo $boomers2Percentage; ?>],
                ['Boomers I (1946-1954)', <?php echo $boomers1Percentage; ?>],
                ['Post War (1928-1945)', <?php echo $postWarPercentage; ?>],
                ['WWII (1922-1927)', <?php echo $ww2Percentage; ?>],
                ['După 2012', <?php echo $after2012Percentage; ?>]
            ]);

            const options = {
                title: 'Distribuție în generații ',
                is3D: true,
                slices: {
                    0: { color: '#FF6384' }, // Gen Z
                    1: { color: '#36A2EB' }, // Millennials
                    2: { color: '#FFCE56' }, // Gen X
                    3: { color: '#4BC0C0' }, // Boomers II
                    4: { color: '#9966FF' }, // Boomers I
                    5: { color: '#FF9F40' }, // Post War
                    6: { color: '#FF5733' }, // WWII
                    7: { color: '#6E3A3A' }  // După 2012
                }
            };
            const chart = new google.visualization.PieChart(document.getElementById('chartContainer'));
            chart.draw(data, options);
        }

        window.addEventListener('resize', drawChart);

        function exportToCSV() {
            const data = google.visualization.arrayToDataTable([
                ['Categorie', 'Procent'],
                ['Gen Z (1997-2012)', <?php echo $genZPercentage; ?>],
                ['Millennials (1981-1996)', <?php echo $millennialsPercentage; ?>],
                ['Gen X (1965-1980)', <?php echo $genXPercentage; ?>],
                ['Boomers II (1955-1964)', <?php echo $boomers2Percentage; ?>],
                ['Boomers I (1946-1954)', <?php echo $boomers1Percentage; ?>],
                ['Post War (1928-1945)', <?php echo $postWarPercentage; ?>],
                ['WWII (1922-1927)', <?php echo $ww2Percentage; ?>],
                ['După 2012', <?php echo $after2012Percentage; ?>]
            ]);
            const csvContent = google.visualization.dataTableToCsv(data);
            downloadFile(csvContent, 'chart_data.csv', 'text/csv');
        }

        function downloadFile(content, filename, contentType) {
            const element = document.createElement('a');
            const file = new Blob([content], { type: contentType });
            element.href = URL.createObjectURL(file);
            element.download = filename;
            document.body.appendChild(element); 
            element.click();
            document.body.removeChild(element);
        }
    </script>

    <?php
    include ("components/footer.html");
    ?>
</body>
</html>
