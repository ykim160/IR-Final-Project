<!DOCTYPE html>
<html>
<title>Davids Stash</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif}
.w3-bar-block .w3-bar-item {padding:20px}
* {box-sizing: border-box;}

#myInput {
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 2px solid #ccc;
  margin-bottom: 12px;
}
</style>
<body>

<!-- Top menu -->
<div class="w3-top">
  <div class="w3-white w3-xlarge" style="max-width:1200px;margin:auto">
    <div class="w3-center w3-padding-16">David's Stash</div>
  </div>
</div>

<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">
<form method="post">
<input type="text" id="myInput"  placeholder="Search.." name="userinput">
</form>
</div>

<?php

include 'open.php';

$search = $_POST['userinput'];
$tokenized = ucwords(strtolower($search));
$parts = preg_split('/\s+/', $tokenized);
$queries = array();
foreach ($parts as $value) {
  $sql="SELECT * FROM $value";
  $result = mysqli_query($mysqli, $sql);
  array_push($queries, $result);
}
$tables = array_filter($queries);

echo '<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">';
echo '<div class="w3-row-padding w3-padding-16 w3-center">';	
if (count($tables) != 0) {
  foreach ($tables as $value) {
    while($row=mysqli_fetch_array($value)) {
      echo '<div class="w3-quarter">';
      $tmp = $row['Url'];
      $tmp2 = $row['Title'];
      echo '<img src='.$tmp.' style="width:100%">';
      echo '<h3>'.$tmp2.'</h3>';
      echo '</div>';
    }
  }
}
echo '</div>';
echo '</div>';

?>
<!-- !PAGE CONTENT! -->
<!--
<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">
-->
  <!-- First Photo Grid-->
<!--
  <div class="w3-row-padding w3-padding-16 w3-center">
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" style="width:100%">
      <h3>I bought a beer cozy that looks like a ballistic vest and it fits on my dog</h3>
    </div>
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" alt="Steak" style="width:100%">
      <h3>What Is Taking So Long David San</h3>
    </div>
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" alt="Cherries" style="width:100%">
      <h3>Im Done With This Final Project</h3>
    </div>
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" alt="Pasta and Wine" style="width:100%">
      <h3>No Answer In Piazza Feels Good</h3>
    </div>
   </div>
 
  </div>
 --> 
  <!-- Second Photo Grid-->
<!--
  <div class="w3-row-padding w3-padding-16 w3-center">
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" alt="Popsicle" style="width:100%">
      <h3>All I Need Is Love??</h3>
    </div>
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" alt="Salmon" style="width:100%">
      <h3>Love Is All I Need!!</h3>
    </div>
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" alt="Sandwich" style="width:100%">
      <h3>Nice Meme Bro David Cant Find It</h3>
    </div>
    <div class="w3-quarter">
      <img src="https://i.imgur.com/H37kxPH.jpg" alt="Croissant" style="width:100%">
      <h3>No Love For David. Forever Alone</h3>
    </div>
  </div>
-->
  <!-- Pagination
  <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a href="#" class="w3-bar-item w3-button w3-hover-black">«</a>
      <a href="#" class="w3-bar-item w3-black w3-button">1</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">2</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">3</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">4</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">»</a>
    </div>
  </div> -->
</div>

<script>

</script>

</body>
</html>

<!--
<head>
    <title>David's Stash</title>
</head>

<body>

<?php
/*
include 'open.php';

    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<style>';
    echo 'img { 
	      width:200;
              height:200;
          }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    $image = 'https://i.imgur.com/H37kxPH.jpg';
    $imageData = base64_encode(file_get_contents($image));
    echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
    echo '</body>';
    echo '</html>';
 */
?>

</body>
-->
