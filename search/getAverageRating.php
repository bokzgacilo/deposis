<?php
  include('../connection.php');
  $target = $_POST['target'];

  $sql = "SELECT * FROM rating WHERE name='$target'";
  $result = $conn -> query($sql);

  function computeRating($totalRate){
    $getAverage = $GLOBALS['conn'] -> query("SELECT * FROM rating WHERE name='".$GLOBALS['target']."'");
    $average = '';
    $desc = '';

    while($row = $getAverage -> fetch_array()){
      $average = $row['average'];
      $description = $row['description'];
    }

    $exploded = explode('%%', $description);
    $rate_array = [];
    $rate = '';

    unset($exploded[0]);

    foreach($exploded as $item){
      $item_rate = explode(',', $item);
      $rate = $item_rate[1];
      array_push($rate_array, $rate);
    }
    
    $sum = array_sum($rate_array);
    $answer = ($sum / $totalRate);
    $GLOBALS['conn'] -> query("UPDATE rating SET average='$answer' WHERE name='".$GLOBALS['target']."'");
    $percentile = (($answer/5) * 100);
    $average = number_format($answer, 2);

    echo $average . ' out of 5: ' .  number_format($percentile, 2) . '%';
    echo "
    <div class='rating'>
      <div class='rating-upper' style='width:".number_format($percentile)."%'>
          <span>★</span>
          <span>★</span>
          <span>★</span>
          <span>★</span>
          <span>★</span>
      </div>
      <div class='rating-lower'>
          <span>★</span>
          <span>★</span>
          <span>★</span>
          <span>★</span>
          <span>★</span>
      </div>
    </div>";
  }

  while($row = $result -> fetch_array()){
    $averageRating = $row['average'];
    $rateCount = $row['rate_count'];
    $desc = $row['description'];

    if($desc == ''){
      $desc = 'none';
    }

    echo "<p>Average Rating: "; computeRating($rateCount); echo "</p>";
    echo "<p>Number of rates: $rateCount</p>";

    $desc = $row['description'];
    $exploded = explode('%%', $desc);

    echo "<p> Users who rate: ";
    foreach ($exploded as $item) {
      $name = explode(',', $item);
      echo $name[0] . " ";
    }
    echo "</p>";

    
  }

  $conn -> close();
?>