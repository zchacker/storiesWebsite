<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="style.css">

  <style>
    * {
      box-sizing: border-box
    }

    body {
      font-family: Verdana, sans-serif;
      margin: 0
    }

    .mySlides {
      display: none
    }

    img {
      vertical-align: middle;
    }

    /* Slideshow container */
    .slideshow-container {
      max-width: 800px;
      position: relative;
      margin: auto;
    }

    /* Next & previous buttons */
    .prev,
    .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      padding: 16px;
      margin-top: -22px;
      color: white;
      font-weight: bold;
      font-size: 18px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }

    /* Caption text */
    .text {
      color: #f2f2f2;
      font-size: 15px;
      padding: 8px 12px;
      position: absolute;
      bottom: 8px;
      width: 100%;
      text-align: center;
    }

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }

    /* The dots/bullets/indicators */
    .dot {
      cursor: pointer;
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }

    .active,
    .dot:hover {
      background-color: #717171;
    }

    /* Fading animation */
    .fade {
      -webkit-animation-name: fade;
      -webkit-animation-duration: 1.5s;
      animation-name: fade;
      animation-duration: 1.5s;
    }

    .silde_content {
      background-color: #F7DE53;
      min-height: 500px;
      max-height: auto;
      width: 100%;
      font-size: 28px;
      direction: rtl;
      text-align: justify;
      padding-left: 45px;
      padding-right: 45px;
      padding-bottom: 50px;
      padding-top: 70px;
      word-wrap: break-word;
    }

    h2 {
      text-align: right;
    }

    audio {
      width: 100%;
      margin: auto;
      align-items: center;
    }

    .slide_img {
      width: 100%;
      height: 100%;
    }

    @-webkit-keyframes fade {
      from {
        opacity: .4
      }

      to {
        opacity: 1
      }
    }

    @keyframes fade {
      from {
        opacity: .4
      }

      to {
        opacity: 1
      }
    }

    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {

      .prev,
      .next,
      .text {
        font-size: 11px
      }
    }
  </style>



</head>

<body>

  <!-- Header -->
  <header class="w3-container w3-center w3-padding-32">
    <img src="logo.jpg" alt="" width="100" height="100" />
    <p>مرحبا بكم في موقع <span class="w3-tag">قصتي</span></p>
    <div class="topnav">
      <a class="active" href="index.php">الرئيسية</a>
      <a href="about.html">عن الموقع</a>
      <a href="what_is_story.html">ما هي القصص الاجتماعية</a>
      <a href="add_story2.html">أضف قصة</a>
      <a href="contactus.html">اتصل بنا</a>
    </div>
  </header>

  <?php

  include_once "database_connect.php";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `stories` WHERE id =  $id LIMIT 1;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
  ?>


      <div class="slideshow-container">
        <h2><?= $row['title'] ?></h2>

        <?php
        $details_sql = "SELECT * FROM `story_parts` WHERE story_id = $id";
        $details_result = $conn->query($details_sql);
        $counter = 1;

        while ($details_row = $details_result->fetch_assoc()) {
          ++$counter;
        ?>

          <div class="mySlides fade">
            
            <div class="numbertext">2 / 4</div>
            <img class="slide_img" src="<?= 'images/' . $details_row['image'] ?>" style="width:100%">            

            <div class="numbertext">1 / 4</div>
            <p class="silde_content"><?= $details_row['body'] ?></p>            

            <?php if (strlen($details_row['audio']) > 0) { ?>
              <audio controls="controls">
                <source src="<?= 'audios/' . $details_row['audio'] ?>" type="audio/mpeg">
              </audio>
            <?php } ?>

          </div>          

        <?php } ?>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

      </div>
      <br>

      <div style="text-align:center;margin-bottom: 100px;">
        <?php
        for ($i = 0; $i <= $counter; $i++) {
          echo '<span class="dot" onclick="currentSlide(' . ($i + 1) . ')"></span> ';
        }
        ?>
        <!-- <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
  <span class="dot" onclick="currentSlide(4)"></span>  -->
      </div>


  <?php
    } else {
      echo "<h1>القصة غير موجودة</h1>";
    }
  } else {
    echo "<h1>الرابط غير صحيح</h1>";
  }

  ?>
  <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {
        slideIndex = 1
      }
      if (n < 1) {
        slideIndex = slides.length
      }
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
    }
  </script>

</body>

</html>