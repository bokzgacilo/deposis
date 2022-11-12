<?php
  include('../connection.php');
  $target = $_POST['table'];
  
  $update = "UPDATE {$target} SET email='gacilo.087481@globalcity.sti.edu.ph' WHERE email='agacilo.087481@globalcity.sti.edu.ph'";
  $conn -> query($update);

  $tables = ['admin', 'students', 'faculty'];
  $key = array_search($target, $tables);

  unset($tables[$key]);

  foreach ($tables as $table) {
    $sql = "UPDATE {$table} SET email='agacilo.087481@globalcity.sti.edu.ph' WHERE email='gacilo.087481@globalcity.sti.edu.ph'";
    $result = $conn -> query($sql);

    if($result){
      echo 'success';
    }
  }
  
  $conn -> close();
?>