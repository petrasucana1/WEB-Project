<?php
include_once '../app/models/News.php';
include ("components/navbar.html");
$newsObj = new News();
$latestNews = $newsObj->getNewsWithPagination(0, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Actors Guild Awards</title>
    <link rel="stylesheet" href="styles/styles_home.css">
    <link rel="stylesheet" href="styles/styles_nav_footer.css">
</head>
<body>
    <section class="top_body">
        <h2>Welcome to the Screen Actors Guild Awards</h2>
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="photos/half_page_background.jpg" style="width:100%; height:60vw;" alt="Slide photos">
            </div>
            <div class="mySlides fade">
                <img src="photos/1slide.jpg" style="width:100%; height:60vw;" alt="Photo1">
            </div>
            <div class="mySlides fade">
                <img src="photos/2slide.png" style="width:100%; height:60vw;" alt="Photo2">
            </div>
            <div class="mySlides fade">
                <img src="photos/4slide.jpg" style="width:100%; height:60vw;" alt="Photo3">
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
        </div>
        <button class="button"> <a href="../views/Nominees.php"><span>Nominees & Recipients</span></a></button> 
    </section>

    <section class="bottom_body">
        <div class="left_bottom_body">
            <h1><a href="../views/News.php">NEWS</a></h1>
            <?php if ($latestNews): ?>
                <?php foreach ($latestNews as $news): ?>
                    <h3><?php echo htmlspecialchars($news['Date']); ?></h3>
                    <p><a href="<?php echo htmlspecialchars($news['Link']); ?>" target="_blank"><?php echo htmlspecialchars($news['Title']); ?></a></p>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No news available.</p>
            <?php endif; ?>
        </div>
        <div class="right_bottom_body">
            <img src="photos/news_photo.png" alt="Imagine" style="width:100%;">
        </div>
    </section>
    <script>
        let slideIndex = 1;
        showSlides(slideIndex);
        
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
        
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }
        
        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }
    </script>
</body>
</html>
<?php
include ("components/footer.html");
?>