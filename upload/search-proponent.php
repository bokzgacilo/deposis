<?php
  session_start();
  include('../connection.php');
  $department = $_SESSION['department'];
  $author = $_POST['author'];
  $sql = "SELECT * FROM students WHERE name LIKE '%$author%' AND department='$department' ORDER BY name ASC";
  $result = $conn -> query($sql);

  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){
      if($row['unique_id'] == 0){
        echo "
        <a class='user d-flex flex-row align-items-center mb-1'>
          <button id='".$row['name']."' onclick='addMe(this.id)' class='me-2'>Add</button>
          <img src='../".$row['profile_picture_url']."'>
          <p class='user'>".$row['name']."</p>
        </a>
        ";
      }
    }
  }else {
    echo "<p class='message'>Student was not existing on the database. Please contact your adviser.</p>";
  }
  

  $conn -> close();
?>