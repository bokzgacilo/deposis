<?php
  session_start();
  include('../connection.php');

  $user = $_SESSION['email'];
  $rate = $_POST['rate'];
  $target = $_POST['file'];
  
  function UpdateCounter(){
    $getCounter = $GLOBALS['conn'] -> query("SELECT * FROM approved WHERE unique_id='".$GLOBALS['target']."'");
    $counter = '';

    while($row = $getCounter -> fetch_array()){
      $counter = $row['rate_count'];
    }

    $newCounter = $counter + 1;
    $GLOBALS['conn'] -> query("UPDATE approved SET rate_count=$newCounter WHERE unique_id='".$GLOBALS['target']."'");
  }

  function computeAverage($currentRate){
    $getAverage = $GLOBALS['conn'] -> query("SELECT * FROM approved WHERE unique_id='".$GLOBALS['target']."'");
    $lastAverage = '';
    $desc = '';
    
    while($row = $getAverage -> fetch_array()){
      $lastRate_Count = $row['rate_count'];
      $lastAverage = $row['average'];
    }
    
    $process = (($lastAverage + $currentRate) / $lastRate_Count);
    $percentile = number_format($process, 2);

    $GLOBALS['conn'] -> query("UPDATE approved SET average='$percentile' WHERE unique_id='".$GLOBALS['target']."'");
  }

  $sql = "SELECT * FROM approved WHERE unique_id='$target'";
  $result = $conn -> query($sql);
  $desc = '';

  while($row = $result -> fetch_array()){
    $desc = $row['rater'];
  }

  $newDesc = explode('%%', $desc);
  if (strpos($desc, $user) !== false) {
    echo 'true';
  }else {
    UpdateCounter();
    computeAverage($rate);

    if($desc != ''){
      $addline = "%%" .  $user . ", " . $rate;
      $newline = $desc . $addline;
    }else {
      $addline = "%%" . $user . ", " . $rate ;
      $newline = $addline;
    }

    $conn -> query("UPDATE approved SET rater='$newline' WHERE unique_id='$target'");
  }
?>