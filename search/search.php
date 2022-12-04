  <?php
  session_start();
  $usertable = '';

  if(isset($_SESSION['table'])){
    $usertable = $_SESSION['table'];
  }

  

  include('../connection.php');
  $keyword = $_POST['keyword'];

  if(isset($_SESSION['email'])){
    $getSavedThesis = "SELECT * FROM $usertable WHERE email='".$_SESSION['email']."'";
    
    $getsaved = $conn -> query($getSavedThesis);
    $bookmarks = '';
  
    while($saves = $getsaved -> fetch_array()){
      if($saves['saved_thesis'] != ''){
        $bookmarks = explode('%%', $saves['saved_thesis']);
      }
    }
  }

  $sql = "SELECT * FROM approved WHERE title LIKE '%$keyword%'";
  $result = $conn -> query($sql);
  // $counter = $result -> num_rows;
  
  if(($result -> num_rows) > 0){
    while($thesis = $result -> fetch_array()){
      $authors =  explode("%%", $thesis['authors']);
      echo "<div class='mb-1 thesis'>
      <a href='../pdf-viewer/index.php?file=".$thesis['unique_id']."'>
        <p class='thesis-head' title='".$thesis['title']."'>".$thesis['title']."</p>
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
        <p>".$thesis['abstract']."</p>
      </div>";

      if(isset($_SESSION['role'])){
        echo "<div class='thesis-actions'>";

        $checkBookmark = "SELECT saved_thesis FROM $usertable";

        if($bookmarks != ''){
          if (in_array($thesis['unique_id'], $bookmarks)) {
            echo "<a id='".$thesis['unique_id']."' class='unsave selected'>
              <i class='fa-regular fa-heart'></i>
              <p class='fsss'>Saved</p>
            </a>";
          }else {
            echo "<a id='".$thesis['unique_id']."' class='save'>
              <i class='fa-regular fa-heart'></i>
              <p class='fsss'>Save</p>
            </a>";
          }
        }else {
          echo "<a id='".$thesis['unique_id']."' class='save'>
            <i class='fa-regular fa-heart'></i>
            Save
          </a>";
        }
        $average = $thesis['average'];
        $rate_count = $thesis['rate_count'];
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
        <p class='pub_date'>".$thesis['department'].", ".$thesis['publication_date'].", Approved Date:".$thesis['approved_date']."</p>
      </div>";
      }
      echo "</div>";
    }
  }else {
    echo "<p class='p-2 '>No results found for '$keyword'</p>";
  }
  

  $conn -> close();
?>