<?php
    include ("components/navbar.html");
    $selected_year = isset($_GET['year']) ? $_GET['year'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles_nominees.css">

</head>
<body>
<section class="top_body">
    <div class="image"></div>
    <div class="serch_bar">
        <form id="yearForm" method="GET">
            <div class="drop_down_list">
                <select name="year" id="edition">
                    <?php
                    for ($year = 2023; $year >= 1995; $year--) {
                        echo '<option value="' . $year . '" >' ;
                        echo $year . ' Screen Actors Guild Awards</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="button" class="SearchButton" onclick="window.location.href='Search.php'"><span>Search</span></button>
        </form>
    </div>
</section>
<section class="nominees">
       
</section>
</body>
<script>
    
    function loadNominees(year) {
        let http = new XMLHttpRequest();
        http.open('GET', "NomineesView.php?year=" + year, true);
        
        let container = document.querySelector(".nominees");

        http.onreadystatechange = function() {
            if (http.readyState === XMLHttpRequest.DONE) {
                if (http.status === 200) {
                    container.innerHTML = http.responseText;
                } else {
                    container.innerHTML = 'Error: ' + http.status;
                }
            }
        };

        http.send();
    }

    // Ascultă evenimentul de schimbare a anului selectat
    let selectMenu = document.querySelector("#edition");
    selectMenu.addEventListener("change", function(){
        let selected_year = this.value;
        loadNominees(selected_year);
    });

    window.onload = function() {
        let selected_year = selectMenu.value;
        loadNominees(selected_year);
    };
</script>
</html>
<?php
    include ("components/footer.html");
?>