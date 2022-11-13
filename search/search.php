  <?php
  session_start();

  include('../connection.php');

  $keyword = $_POST['keyword'];


  $sql = "SELECT * FROM approved WHERE title LIKE '%$keyword%' ";
  $result = $conn -> query($sql);
  $counter = $result -> num_rows;

  if($counter != 0){
    // echo "<p class='mt-2'>We found $counter results.</p>";
  }
  if(($result -> num_rows) > 0){
    while($thesis = $result -> fetch_array()){
      $authors =  explode("%%", $thesis['authors']);

      echo "
      <div class='mt-2 thesis'>
      <div >
        <a class='thesis-head' title='".$thesis['title']."' onclick='openThesis(this.title)' >".$thesis['title']."</a>
      </div>
      <div class='thesis-body'>
        <div class='authors'>";
  
        foreach($authors as $author){
          $authorProfilePicture = $conn -> query("SELECT * FROM students WHERE name='$author' ");
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
      </div>
      <div class='thesis-actions'>
        <a id='".$thesis['unique_id']."' class='save'>
          <i class='fa-regular fa-heart'></i>
          Save
        </a>
      </div>
    </div>";
    }
  }else {
    echo "<p class='mt-2'>No results found for '$keyword'</p>";
  }
  

  $conn -> close();
?>