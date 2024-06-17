<?php
include ("components/navbar.html");
include_once '../app/models/Actor.php';
include_once '../app/models/Movie.php';

$actorModel = new Actor();
$movie = new Movie();
$actorsData = $actorModel->getTop20Actors();


$xValues = [];
$yValues = [];

foreach ($actorsData as $actor) {
    // Adăugăm numele actorului în xValues
    $xValues[] = $actor['name']; // presupunând că avem o metodă getName() pentru a obține numele actorului

    // Obținem numărul de filme pentru actorul curent
    $movies = count($movie->getMoviesByActorId($actor['id'])); // presupunând că avem o metodă getId() pentru a obține ID-ul actorului
    // Adăugăm numărul de filme în yValues
    $yValues[] = $movies;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actor Movies Chart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>


<body>
  <div style="width: 80%; height: 500px; margin: auto;">
    <canvas id="myChart"></canvas>
  </div>
  
  <!-- Buton pentru export SVG -->
  <button onclick="exportChart()">Export as SVG</button>

  <script>
    // Datele pentru grafic
    const xValues = <?php echo json_encode($xValues); ?>;
    const yValues = <?php echo json_encode($yValues); ?>;

    // Variabilă globală pentru a reține instanța Chart
    let myChart;

    // Crearea graficului folosind Chart.js
    document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('myChart').getContext('2d');
      myChart = new Chart(ctx, {
        type: "line", // Am schimbat tipul de grafic la line pentru a afișa un grafic de linie
        data: {
          labels: xValues,
          datasets: [{
            label: 'Number of Movies',
            backgroundColor: "rgba(0, 0, 255, 0.1)",
            borderColor: "rgba(0, 0, 255, 1.0)",
            data: yValues,
            fill: false // Pentru a afișa doar linia, fără umplere
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            xAxes: [{
              scaleLabel: {
                display: true,
                labelString: 'Actors'
              }
            }],
            yAxes: [{
              scaleLabel: {
                display: true,
                labelString: 'Number of Movies'
              },
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    });

    // Funcția pentru export SVG
    function exportChart() {
      const svg = myChart.toBase64Image();
      const downloadLink = document.createElement('a');
      downloadLink.href = svg;
      downloadLink.download = 'chart.svg';
      downloadLink.click();
    }
  </script>
</body>
</html>
<?php
    include ("components/footer.html");
?>
