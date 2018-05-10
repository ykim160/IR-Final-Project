<!DOCTYPE html>
<html>
<title>David's Stash</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Karma", sans-serif}
.w3-bar-block .w3-bar-item {padding:20px}
* {box-sizing: border-box;}
h4 {
  background-color: #33D1FF;
}

#myInput {
  width: 100%;
  font-size: 20px;
  padding: 12px 20px 12px 40px;
  border: 2px solid #ccc;
  margin-bottom: 12px;
}
</style>
<body>

<!-- Top menu -->
<div class="w3-top">
  <div class="w3-white w3-xxlarge" style="max-width:1200px;margin:auto">
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
      echo '<h4>'.$tmp2.'</h4>';
      echo '</div>';
    }
  }
} else {
  for ($i = 0; $i < 3; $i++) {
    $rando = rand(0, 9);
    $value = "";
    if ($rando == 0) {
      $value = "Awesome";
    } elseif ($rando == 1) {
      $value = "Aww";
    } elseif ($rando == 2) {
      $value = "Creativity";
    } elseif ($rando == 3) {
      $value = "Current_events";
    } elseif ($rando == 4) {
      $value = "Dog";
    } elseif ($rando == 5) {
      $value = "Funny";
    } elseif ($rando == 6) {
      $value = "Gaming";
    } elseif ($rando == 7) {
      $value = "Inspiring";
    } elseif ($rando == 8) {
      $value = "Reaction";
    } else {
      $value = "Science_and_tech";  
    }

    $sql="SELECT * FROM $value ORDER BY RAND() LIMIT 4";
    $result = mysqli_query($mysqli, $sql);
    while($row = mysqli_fetch_array($result)) {
      echo '<div class="w3-quarter">';
      $tmp = $row['Url'];
      $tmp2 = $row['Title'];
      echo '<img src='.$tmp.' style="width:100%">';
      echo '<h4>'.$tmp2.'</h4>';
      echo '</div>';
    }
  }
}
echo '</div>';
echo '</div>';

?>

<script>

</script>

</body>
</html>


