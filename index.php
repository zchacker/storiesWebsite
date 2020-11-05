<!DOCTYPE html>
<html>
<title>قصص الزوار</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="style.css?v=3">
<style>
  body,
  h1,
  h2,
  h3,
  h4,
  h5 {
    font-family: "Raleway", sans-serif
  }
</style>

<body class="w3-light-grey">

  <!-- w3-content defines a container for fixed size centered content, 
and is wrapped around the whole page content, except for the footer in this example -->
  <div class="w3-content" style="max-width:1400px">

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

    <!-- Grid -->
    <div class="w3-row">
      
    
      <!-- Blog entries -->
      <div class="w3-col 20 s12" style="width: 650px;margin: auto;float: inherit;">
              
        <?php

        include_once "database_connect.php";

        $sql = "SELECT * FROM `stories` ORDER BY `stories`.`id` DESC";
        $result = $conn->query($sql);
        $row = null;

        $last_photo = "";

        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {

            $photo_sql    = "SELECT * FROM `story_parts` WHERE story_id = " . $row["id"] . ";";
            $photo_result = $conn->query($photo_sql);
            $photo_row    = $photo_result->fetch_assoc();
            $last_photo   = $photo_row["image"];
        ?>
            <!-- Blog entry -->
            <div class="w3-card-4 w3-margin w3-white">
              <a href="<?php echo "story.php?id=" . $row["id"]; ?>">
                <img src="<?php echo "images/" . $photo_row["image"]; ?>" alt="Nature" style="width:100%">
                <div class="w3-container">
                  <h3><b><?php echo $row["title"]; ?></b></h3>
                  <!-- <h5>اضغط على الصورة لتفاصيل القصة, <span class="w3-opacity">April 7, 2014</span></h5> -->
                </div>
              </a>
            </div>
            <hr>

        <?php
          }
        } else {
          echo '<div class="w3-card-4 w3-margin w3-white" style="direction: rtl;font-size:18px;">لا توجد قصص</div>';
        }
        $conn->close();

        ?>
                
        <!-- END BLOG ENTRIES -->
      </div>
      
      

      <!-- Introduction menu -->
      <?php
      if ($row != null) {
      ?>

        <div class="w3-col l4">
          <!-- About Card -->
          <div class="w3-card w3-margin w3-margin-top">
            <img src="<?= "images/" . $last_photo; ?>" style="width:100%">
            <div class="w3-container w3-white">
              <h4><b>آخر القصص المضافة</b></h4>
              <p><?= $row["title"]; ?></p>
            </div>
          </div>
          <hr>

          <!-- END Introduction Menu -->
        </div>

      <?php } ?>

      <!-- END GRID -->
    </div><br>

    <!-- END w3-content -->
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  </footer>

</body>

</html>