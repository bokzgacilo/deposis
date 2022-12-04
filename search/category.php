<?php
  $usertable = '';
  $bookmarks = '';
  session_start();
  include('../connection.php');

  $category = $_POST['category'];

  $sql = "SELECT * FROM approved WHERE category='$category'";
  $result = $conn -> query($sql);

  if(($result -> num_rows) > 0){
    while($row = $result -> fetch_array()){
      $authors =  explode("%%", $row['authors']);
      echo "<div class='mb-1 thesis'>
      <a href='../pdf-viewer/index.php?file=".$row['unique_id']."'>
        <p class='thesis-head' title='".$row['title']."'>".$row['title']."</p>
      </a>
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
          echo "<a>
            <img src='../$auth_profile_picture'>
            <p>$author</p>
          </a>";
        }
      echo "</div>
        <p>".$row['abstract']."</p>
        <p>Approved on: ".$row['approved_date']."</p>
      </div>";

      if(isset($_SESSION['role'])){
        echo "<div class='thesis-actions'>";

        $checkBookmark = "SELECT saved_thesis FROM $usertable";

        if($bookmarks != ''){
          if (in_array($row['unique_id'], $bookmarks)) {
            echo "<a id='".$row['unique_id']."' class='unsave selected'>
              <i class='fa-regular fa-heart'></i>
              <p class='fsss'>Saved</p>
            </a>";
          }else {
            echo "<a id='".$row['unique_id']."' class='save'>
              <i class='fa-regular fa-heart'></i>
              <p class='fsss'>Save</p>
            </a>";
          }
        }else {
          echo "<a id='".$row['unique_id']."' class='save'>
            <i class='fa-regular fa-heart'></i>
            Save
          </a>";
        }

        $average = $row['average'];
        $rate_count = $row['rate_count'];
        $percentile = (($average / 5) * 100);

        echo"
        <div class='rate-holder'>
          <p class='pub_date'>Average Rate: ".number_format($average, 2)." ($percentile%)</p>
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
          </div>
          <p>Number of rates: $rate_count</p>
        </div>
        <p class='pub_date'>".$row['department'].", ".$row['publication_date']."</p>
      </div>";
      }
      echo "</div>";
    }
  }else {
    echo "<p class='p-2 '>No results found for '$keyword'</p>";
  }
  // echo $category;

  $conn -> close(); 
?>