<?php
  include('../connection.php');
  $exploded = explode('%%', $_GET['comments']);

  if($exploded['0'] == ''){
    echo 'No comments available.';
  }
  
  if(count($exploded) >= 1) {
    foreach ($exploded as $exploded_item) {
      $new = explode('$$$', $exploded_item);
      $email = $new['0'];
      $user_profile_picture = '';
      $user_name = '';
      

      $tables = ['admin', 'faculty', 'students'];
      foreach ($tables as $item) {
        $sql = "SELECT * FROM {$item} WHERE email='$email'";
        $get = $conn -> query($sql);
        
        if(($get -> num_rows) > 0){

          while($row = $get -> fetch_array()){
            $user_profile_url = $row['profile_picture_url'];
            $user_name = $row['name'];
          }

          echo "
          <div class='comment'>
            <div class='commentor'>
              <img src='../$user_profile_url'>
            </div>
            <div class='details'>
              <p>$user_name</p>
              <p>".$new['1']."</p>
            </div>
          </div>";
        }
      }
    }
  }

  $conn -> close();
?>