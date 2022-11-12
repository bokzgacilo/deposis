<?php
  session_start();
  include('../connection.php');
  
  $table = $_POST['table'];
  $keyword = $_POST['keyword'];
  $department = $_SESSION['department'];
  
  if($keyword == ''){
    echo "<td class='pt-2 pb-2' style='text-align:center;'>Type any words to search.</a></td>";
  }else {
    if($table == 'pending' || $table == 'approved'){
      $sql = '';
      if(isset($_SESSION['department'])){
        $sql = "SELECT * FROM $table WHERE department='$department' AND title LIKE '%$keyword%'";
      }else {
        $sql = "SELECT * FROM $table WHERE title LIKE '%$keyword%' OR authors LIKE '%$keyword%' OR department LIKE '%$keyword%'";
      }
  
      $result = $conn -> query($sql); 
  
      if(($result -> num_rows) > 0){
        while($row = $result -> fetch_array()){
          if($table == 'approved'){
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
      }else {
        echo "<td class='pt-2 pb-2' style='text-align:center;'>No results found. For more assistance and support. Email us on <a href='mailto:server.deposis@gmail.com'>server.deposis@gmail.com</a></td>";
      }
    }else {
      $sql = '';
      if(isset($_SESSION['department'])){
        $sql = "SELECT * FROM $table WHERE department='$department' AND name LIKE '%$keyword%' ORDER BY email ASC LIMIT 0,11";
      }else {
        $sql = "SELECT * FROM $table WHERE name LIKE '%$keyword%' OR department LIKE '%$keyword%'";
      }
  
      $result = $conn -> query($sql);
  
      if(($result -> num_rows) > 0){
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
      }else {
        echo "<td class='pt-2 pb-2' style='text-align:center;'>No results found. For more assistance and support. Email us on <a href='mailto:server.deposis@gmail.com'>server.deposis@gmail.com</a></td>";
      }
    }
  }

  

  echo $keyword;
  $conn -> close();
?>