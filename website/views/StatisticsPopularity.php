<?php
include ("components/navbar.html");
include_once '../app/models/Actor.php';
$actor = new Actor();
$actors = $actor->getTop10Actors(); 
$labels = [];
$data = [];

foreach ($actors as $top_actor) {
    $labels[] = $top_actor['name']; 
    $data[] = $top_actor['popularity']; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafic Bară Responsive cu Butoane</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
        
        }
        #chartContainer {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }
        canvas {
            width: 100% !important;
            height: auto !important;
        }
        .buttons-container {
            text-align: center;
            margin-top: 20px;
        }
        .export-button {
            padding: 10px 20px;
            font-size: 16px;
            margin-right: 10px;
            margin-top: 20px; 
            margin-bottom: 30px;
        }
        .export-button button:hover {
        background-color: grey;
          }

        .description{
            margin:30px;
        }
    </style>
</head>
<body>
    <div id="chartContainer">
        <canvas id="barChart"></canvas>
    </div>
    <div class="description">This page features a compelling chart showcasing the popularity metrics of the top 10 actors from our database. Each actor's popularity is represented by their ranking based on various performance indicators. The chart visually illustrates the popularity distribution among these leading actors, providing valuable insights into their prominence within the industry.</div>
    <div class="buttons-container">
        <button class="export-button" id="downloadBarBtn">Exportă grafic bară ca WEBP</button>
    </div>
    
    <script>
        var barCtx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Top 10 Actors - Popularity',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        document.getElementById('downloadBarBtn').addEventListener('click', function() {
            html2canvas(barCtx.canvas).then(function(canvas) {
                var webpData = canvas.toDataURL('image/webp');
                var link = document.createElement('a');
                link.href = webpData;
                link.download = 'grafic_bar.webp';
                link.click();
            });
        });
    </script>
</body>
</html>
<?php
    include ("components/footer.html");
?>
