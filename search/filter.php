<?php
  // include('index.php');
  session_start();

  $usertable = '';

  if(isset($_SESSION['table'])){
    $usertable = $_SESSION['table'];
  }

  include('../connection.php');

  $keyword = $_POST['keyword'];
  $department = $_POST['department'];
  $date_from = $_POST['date_from'];
  $date_to = $_POST['date_to'];
  $sql = '';

  if(!empty($keyword) && empty($department) && !empty($date_from) && !empty($date_to)){
    $sql = "SELECT * FROM approved WHERE title LIKE '%$keyword%' AND publication_date >= '$date_from' AND publication_date <= '$date_to'";
  }

  if(empty($keyword) && !empty($department) && !empty($date_from) && !empty($date_to)){
    $sql = "SELECT * FROM approved WHERE department LIKE '%$department%' AND publication_date >= '$date_from' AND publication_date <= '$date_to'";
  }
  if(empty($keyword) && !empty($department) && empty($date_from) && empty($date_to)){
    $sql = "SELECT * FROM approved WHERE department LIKE '%$department%'";
  }

  if(!empty($keyword) && empty($department) && empty($date_from) && empty($date_to)){
    $sql = "SELECT * FROM approved WHERE title LIKE '%$keyword%'";
  }

  if(empty($keyword) && empty($department) && !empty($date_from) && !empty($date_to)){
    $sql = "SELECT * FROM approved WHERE publication_date >= '$date_from' AND publication_date <= '$date_to'";
  }

  if(empty($keyword) && empty($department) && !empty($date_from) && empty($date_to)){
    $sql = "SELECT * FROM approved WHERE publication_date >= '$date_from'";
  }

  if(empty($keyword) && empty($department) && empty($date_from) && empty($date_to)){
    $sql = "SELECT * FROM approved";
  }

  if(!empty($keyword) && !empty($department) && empty($date_from) && empty($date_to)){
    $sql = "SELECT * FROM approved WHERE title LIKE '%$keyword%' AND department LIKE '%$department%'";
  }
  $result = $conn -> query($sql);
  if(($result -> num_rows) > 0){
    while($thesis = $result -> fetch_array()){
      $authors =  explode("%%", $thesis['authors']);

      echo "
      
      <div class='mt-2 thesis'>
      <div >
        <p class='thesis-head' title='".$thesis['title']."' onclick='openThesis(this.title)' >".$thesis['title']."</p>
      </div>
      <div class='thesis-body'>
        <div class='authors'>";
  
        foreach($authors as $author){
          $authorProfilePicture = $conn -> query("SELECT * FROM students WHERE name='$author'");
            $auth_profile_picture = '';
            
            if(($authorProfilePicture -> num_rows) > 0){
              while($pp = $authorProfilePicture -> fetch_array()){ 
                $auth_profile_picture = $pp['profile_picture_url'];
              }
            }else {
              $auth_profile_picture = 'files/default-user.png';
            }
            
              
            echo "<a href=''>
              <img src='../$auth_profile_picture'>
              <p>$author</p>
            </a>";
        }
      echo "</div>
        <p>".$thesis['abstract']."</p>
      </div>";

      if($_SESSION['email'] != 'Guest'){
        echo "<div class='thesis-actions'>
        <a id='".$thesis['unique_id']."' class='save'>
          <i class='fa-regular fa-heart'></i>
          Save
        </a>
        <p class='pub_date'>".$thesis['department'].", ".$thesis['publication_date']."</p>
      </div>
    </div>";
      }
      
    }
  }else {
    echo "<p class='mt-2 text-center'>No results found for the filter parameters.</p>";
  }

  $conn -> close();
?>