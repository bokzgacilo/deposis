<?php
  include('../connection.php');
  
  $tables = ['admin', 'students', 'faculty'];

  foreach ($tables as $table) {
    $threshold = 'agacilo.087481@globalcity.sti.edu.ph';
    $sql = "SELECT * FROM {$table} WHERE email='{$threshold}'";
    $result = $conn -> query($sql);
    
    if(($result -> num_rows) > 0){
      while($row = $result -> fetch_array()){
        echo "
        <p>{$table} <button onclick='switcher(this.id)' id='{$table}'>Switch</button></p>
        <h4>{$row['email']}</h4>
        ";
      }
    }
  }

  foreach ($tables as $table) {
    $sql = "SELECT * FROM {$table} WHERE email='gacilo.087481@globalcity.sti.edu.ph'";
    $result = $conn -> query($sql);
    
    if(($result -> num_rows) > 0){
      while($row = $result -> fetch_array()){
        echo "
        <p>{$table} <span>Selected</span></p>
        <h4>{$row['email']}</h4>
        ";
      }
    }
  }

  


  $conn -> close();
?>