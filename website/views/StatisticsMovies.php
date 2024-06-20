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
    $xValues[] = $actor['name']; 
    $movies = count($movie->getMoviesByActorId($actor['id'])); 
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
  <style>
    body {
        font-family: Arial, sans-serif;
    }
    #chartContainer {
        width: 80%;
        height: 500px;
        margin: auto;
        margin-top: 20px; 
    }
    .export-buttons {
        text-align: center;
        margin-top: 20px; 
    }
    .export-buttons button {
        margin: 10px; 
        padding: 10px 20px;
        cursor: pointer;
        color: black;
        border-radius: 5px;
    }
    .export-buttons button:hover {
        background-color: grey;
    }

    .description{
      margin:30px;
    }

  </style>
</head>
<body>
  <div style="width: 80%; height: 500px; margin: auto;">
    <canvas id="myChart"></canvas>
  </div>
  <div class="description">This page features an insightful chart showcasing the filmography of the top 10 actors based on our database. Each actor's contribution is depicted by the number of films they have starred in, providing a clear visual representation of their prolific careers. The chart allows viewers to understand and compare the cinematic output of these leading actors, offering valuable insights into their extensive roles across various productions.</div>
  <div class="export-buttons">
    <button onclick="exportChart()">Export as SVG</button>
  </div>

  <script>
    const xValues = <?php echo json_encode($xValues); ?>;
    const yValues = <?php echo json_encode($yValues); ?>;

    let myChart;
    document.addEventListener('DOMContentLoaded', function() {
      const ctx = document.getElementById('myChart').getContext('2d');
      myChart = new Chart(ctx, {
        type: "line", 
        data: {
          labels: xValues,
          datasets: [{
            label: 'Number of Movies',
            backgroundColor: "rgba(0, 0, 255, 0.1)",
            borderColor: "rgba(0, 0, 255, 1.0)",
            data: yValues,
            fill: false 
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
    function exportChart() {
      const svg = myChart.toBase64Image();
      const downloadLink = document.createElement('a');
      downloadLink.href = svg;
      downloadLink.download = 'chart.svg';
      downloadLink.click();
    }
  </script>

<?php
include ("components/footer.html");
?>
</body>
</html>
