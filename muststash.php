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
$tokenized = ucwords(strtolower($search));;
$parts = preg_split('/\s+/', $tokenized);
$queries = array();

foreach ($parts as $value) {
  if ($value!="Attack"&&$value!="Attributes"&&$value!="Club"&&$value!="Country"&&$value!="Defense"&&$value!="Midfield"&&$value!="Player"&&$value!="Plays_in"&&$value!="Positions"&&$value!="Preferred"&&$value!="Value") { 
    if ($value == "Current" || $value == "Events" || $value == "Event") {
      $value = "Current_events";
    }
    if ($value == "Science" || $value == "Tech" || $value == "Technology") {
      $value = "Science_and_tech";
    } 
    $sql="SELECT * FROM $value";
    $result = mysqli_query($mysqli, $sql);
    if ($result != null) {
      array_push($queries, $value);;
    }
  }
}

$numb = count($queries);
if ($numb != 0) {
  $sql="SELECT * FROM (";
  foreach ($queries as $value) {
    if ($numb == 1) {
        $sql.= "SELECT * FROM $value) as U";
    } else {
        $sql.= "SELECT * FROM $value UNION ";
        $numb--;
    }
  }
  $sql.=";";
  $result = mysqli_query($mysqli, $sql);

  $import = array();
  $title = array();

  while($row=mysqli_fetch_array($result)) {
    $url = $row['Url'];    
    $one = $row['One'];
    $two = $row['Two'];
    $name = $row['Title'];
    $rank = 0;
    foreach ($queries as $value) { 
      if ($one == strtolower($value)) {
        $rank += 5;
      }
      if ($two == strtolower($value)) {
        $rank += 2;
      }
    }
 
    if (array_key_exists($url, $import)) {	    
      $import[$url] += $rank;
    } else {
      $import[$url] = $rank;
    }
    
    $title[$url] = $name;
  }
  arsort($import); 

  echo '<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">';
  echo '<div class="w3-row-padding w3-padding-16 w3-center">';	
  $limit = 0;
  foreach ($import as $key => $value) {
    if ($limit > 60) {
      break;
    } else {
      echo '<div class="w3-quarter">';
      echo '<img src='.$key.' style="width:100%">';
      echo '<h4>'.$title[$key].'</h4>';
      echo '</div>';
    }
    $limit += 1;
  }
  echo '</div>';
  echo '</div>';
} else {
  echo '<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:50px">';
  echo '<div class="w3-row-padding w3-padding-16 w3-center">';	
      
  for ($i = 0; $i < 5; $i++) {
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
  echo '</div>';
  echo '</div>';
}

?>

<script>

</script>

</body>
</html>


