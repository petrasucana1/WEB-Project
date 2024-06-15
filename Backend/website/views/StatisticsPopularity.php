<?php
include ("html/navbar.html");
include_once '../app/models/Actor.php';
$actor = new Actor();
$actors = $actor->getTop10Actors(); // Presupunând că această metodă returnează un array de actori cu numărul lor și popularitatea

// Inițializăm două array-uri goale pentru a stoca etichetele (numele actorilor) și datele (popularitatea)
$labels = [];
$data = [];

// Parcurgem fiecare actor și adăugăm numele și popularitatea lor în array-urile respective
foreach ($actors as $top_actor) {
    $labels[] = $top_actor['name']; // Presupunând că numele actorului este în câmpul 'nume_actor'
    $data[] = $top_actor['popularity']; // Presupunând că popularitatea este în câmpul 'popularitate'
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafic Bară Responsive cu Butoane</title>
    <link rel="stylesheet" href="styles/styles_nav_footer.css">

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
        }
    </style>
</head>
<body>
    <div id="chartContainer">
        <canvas id="barChart"></canvas>
    </div>
    
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
            // Capturăm canvas-ul cu html2canvas
            html2canvas(barCtx.canvas).then(function(canvas) {
                // Convertim canvas-ul în format WEBP
                var webpData = canvas.toDataURL('image/webp');
                
                // Creăm un element de ancoră pentru a descărca imaginea
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
    include ("html/footer.html");
?>
