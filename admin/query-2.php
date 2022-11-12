<?php

  session_start();
  include('../connection.php');

  $department = $_SESSION['department'];

  if($_POST['table'] == 'students'){
    $sql = '';

    if(!isset($department) || $department == ''){
      $sql = "SELECT * FROM students ORDER BY name ASC ";
    }else {
      $sql = "SELECT * FROM students WHERE department='$department' ORDER BY name ASC ";
    }

    $result = $conn -> query( $sql);
  
    while($row = $result -> fetch_array()){
      echo "<td class='user' id='".$row['id']."'>
      <input name='check_list[]' value='".$row['id']."' type='checkbox' class='larger'>
      <img src='../".$row['profile_picture_url']."'>
      <p class='name' >".$row['name']."</p>
      <a class='email' href='mailto:".$row['email']."'>".$row['email']."</a>
      <p class='dept'>".$row['department']."</p>
      <p class='role'>".$row['role']."</p>
    </td>";
    }
  }else if($_POST['table'] == 'faculty'){
    $sql = "SELECT * FROM faculty ORDER BY name ASC";
    $result = $conn -> query( $sql);
  
    while($row = $result -> fetch_array()){
      echo "<td class='user' id='".$row['id']."'>
      <input name='check_list[]' value='".$row['id']."' type='checkbox' class='larger'>
      <img src='../".$row['profile_picture_url']."'>
      <p class='name' >".$row['name']."</p>
      <a class='email' href='mailto:".$row['email']."'>".$row['email']."</a>
      <p class='dept'>".$row['department']."</p>
      <p class='role'>".$row['role']."</p>
    </td>";
    }
  }else if($_POST['table'] == 'pending'){
    $sql = '';

    if(!isset($department) || $department == ''){
      $sql = "SELECT * FROM pending";
    }else {
      $sql = "SELECT * FROM pending WHERE department='$department'";
    }

    $result = $conn -> query($sql);

    while($row = $result -> fetch_array()){
      if($_POST['table'] == 'approved'){
        $authors = explode('%%', $row['authors']);
      }else {
        $authors = explode('%%', $row['authors']);
      }
      

      echo "<td class='thesis' id='".$row['unique_id']."'>
      <input name='check_list[]' value='".$row['unique_id']."' type='checkbox' class='larger'>
      <a href='../".$row['document_url']."'>View Document  </a>
      <p class='title' >".$row['title']."</p> 
      <p class='authors'>"; 
      
        for ($i = 0; $i < sizeof($authors); $i++) { 
          $getProfile = $conn -> query("SELECT * FROM students WHERE name='$authors[$i]'");
          
          if(($getProfile -> num_rows) > 0){
            while($user = $getProfile -> fetch_array()){
              echo "<img title='".$user['name']."' src='../".$user['profile_picture_url']."'>";
            }
          }else {
            echo "<img title='".$authors[$i]."' src='../assets/default-user.png'>";
          }
        }

      echo "</p>
      <p class='dept'>".$row['department']."</p>
      <p class='pubdate'>".$row['publication_date']."</p>
    </td>";
    }
  }else if($_POST['table'] == 'approved'){
    $sql = '';

    if(!isset($department) || $department == ''){
      $sql = "SELECT * FROM approved";
    }else {
      $sql = "SELECT * FROM approved WHERE department='$department'";
    }

    $result = $conn -> query($sql);

    while($row = $result -> fetch_array()){
      if($_POST['table'] == 'approved'){
        $authors = explode('%%', $row['authors']);
      }else {
        $authors = explode('%%', $row['authors']);
      }
      

      echo "<td class='thesis' id='".$row['unique_id']."'>
      <input name='check_list[]' value='".$row['unique_id']."' type='checkbox' class='larger'>
      <a href='../".$row['document_url']."'>View Document  </a>
      <p class='title' >".$row['title']."</p> 
      <p class='authors'>"; 
      
        for ($i = 0; $i < sizeof($authors); $i++) { 
          $getProfile = $conn -> query("SELECT * FROM students WHERE name='$authors[$i]'");
          
          if(($getProfile -> num_rows) > 0){
            while($user = $getProfile -> fetch_array()){
              echo "<img title='".$user['name']."' src='../".$user['profile_picture_url']."'>";
            }
          }else {
            echo "<img title='".$authors[$i]."' src='../assets/default-user.png'>";
          }
        }

      echo "</p>
      <p class='dept'>".$row['department']."</p>
      <p class='pubdate'>".$row['publication_date']."</p>
    </td>";
    }
  }
  

  $conn -> close();
?>