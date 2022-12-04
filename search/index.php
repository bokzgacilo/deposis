<?php
  session_start();
  include('../connection.php');

  $usertable = '';
    
  if(isset($_SESSION['table'])){
    $usertable = $_SESSION['table'];
  }else {
    header('location: ../index.php?message=Please login first.');
  }

  if(!isset($_SESSION['email']) && !isset($_SESSION['role']) && !isset($_SESSION['department'])){

  }else {
    $selectUserDetails = "SELECT * FROM $usertable WHERE email='".$_SESSION['email']."'";
    $query = $conn -> query($selectUserDetails);
    $userArray = '';
    while($user = $query -> fetch_array()){

      if($_SESSION['role'] == 'Proponent' || $_SESSION['role'] == 'Representative'){
        $userArray = [
          $user['profile_picture_url'], 
          $user['saved_thesis'],
          $user['name'], 
          $user['unique_id']
        ];
      }else {
        $userArray = [
          $user['profile_picture_url'], 
          $user['saved_thesis'],
          $user['name']
        ];
      }
      
      $_SESSION['name'] = $userArray['2'];
    }

    $selectAllThesis = "SELECT * FROM approved";
    $theses = $conn -> query($selectAllThesis);

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
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>Deposis - Search</title>
  
  <script src="../js/jquery.js"></script>
  <script defer src="search-index.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-touch-events/2.0.0/jquery.mobile-events.min.js"> </script>

  <link rel="shortcut icon" type="image/x-icon" href="../files/admin/deposis-icon.ico" />
  <link rel='stylesheet' href="../css/base.css">
  <link rel='stylesheet' href="../css/search-page.css">
</head>
<body>
  <div id='my-thesis' class='mod'>
    <div class="mod-content-thesis">
      <div class="mod-header-thesis">
        <p>My Thesis</p>
        <i class="close fa-solid fa-xmark"></i>
      </div>
      <div class="mod-message-thesis">
        <table>
          <tr>
            <th></th>
            <th>Title</th>
            <th>Department</th>
            <th>Authors</th>
            <th>Publication Date</th>
            <th>Uploaded Date</th>
            <th>Status</th>
          </tr>
          <?php 

          $tables = ['pending', 'approved'];

          foreach ($tables as $item) {
            $checkmythesis = "SELECT * FROM {$item} WHERE unique_id='$userArray[3]'";
            $checkThesis = $conn -> query($checkmythesis);
            if(($checkThesis -> num_rows) > 0){
              $selectOwnThesis = "SELECT * FROM {$item} WHERE unique_id='$userArray[3]'";
              $ownThesis = $conn -> query($selectOwnThesis);
              while($own = $ownThesis -> fetch_array()){
                echo "<tr>
                  <td><a href='../".$own['document_url']."'>View Document</td>
                  <td>".$own['title']."</td>
                  <td>".$own['department']."</td>";

                  $comember = $own['authors'];
                  $comember_exploded = explode('%%', $comember);

                  echo "<td class='comembers'>";
                  foreach($comember_exploded as $author){
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
                    </a> ";
                  }

                  echo "</td>";
                echo "<td>".$own['publication_date']."</td>
                  <td>".$own['uploaded_date']."</td>
                  <td><p class='{$item}'>".$own['status']."</p></td>
                </tr>";
              }
            }
          }
          

          
        ?>
        </table>
      </div>
    </div>
  </div>

  <div id='my-thesis-mobile'>
    <div class="mod-content-thesis">
      <div class="mod-header-thesis">
        <p>My Thesis</p>
        <i class="close fa-solid fa-xmark"></i>
      </div>
      <div class="mod-message-thesis">
        <table>
          <tr>
            <th></th>
            <th>Title</th>
            <th>Department</th>
            <th>Authors</th>
            <th>Publication Date</th>
            <th>Uploaded Date</th>
            <th>Status</th>
          </tr>
          <?php 

          $tables = ['pending', 'approved'];

          foreach ($tables as $item) {
            $checkmythesis = "SELECT * FROM {$item} WHERE unique_id='$userArray[3]'";
            $checkThesis = $conn -> query($checkmythesis);
            if(($checkThesis -> num_rows) > 0){
              $selectOwnThesis = "SELECT * FROM {$item} WHERE unique_id='$userArray[3]'";
              $ownThesis = $conn -> query($selectOwnThesis);
              while($own = $ownThesis -> fetch_array()){
                echo "<tr>
                  <td><a href='../".$own['document_url']."'>View Document</td>
                  <td>".$own['title']."</td>
                  <td>".$own['department']."</td>";

                  $comember = $own['authors'];
                  $comember_exploded = explode('%%', $comember);

                  echo "<td class='comembers'>";
                  foreach($comember_exploded as $author){
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
                    </a> ";
                  }

                  echo "</td>";
                echo "<td>".$own['publication_date']."</td>
                  <td>".$own['uploaded_date']."</td>
                  <td><p class='{$item}'>".$own['status']."</p></td>
                </tr>";
              }
            }
          }
        ?>
        </table>
      </div>
    </div>
  </div>

  <div id="filter-web">
    <div class="filter-content">
      <div class="filter-header">
        <p>Filter</p>
        <i class="close fa-solid fa-xmark"></i>
      </div>
      <form class="filter-form">
        <input type="text" id='keyword' name='keyword' value="" placeholder="Keyword">
        <p>Select Department: </p>
        <select id='department'>
          <option value=''>All</option>
          <option value="BSIT">BSIT</option>
          <option value="BSIS">BSIS</option>
          <option value="BACOMM">BACOMM</option>
          <option value="THM">THM</option>
          <option value="BSCOE">BSCOE</option>
        </select>
        <p>From: </p>
        <input type="date" value="" name="date_from">
        <p>To: </p>
        <input type="date" value="" name="date_to">
        <button class="go-filter">Filter</button>
      </form>
    </div>
  </div>

  <div id="filter">
    <div class="filter-content">
      <div class="filter-header">
        <p>Filter</p>
        <i class="filter-close fa-solid fa-xmark"></i>
      </div>
      <form class="filter-form">
        <input type="text" id='keyword' name='keyword' value="" placeholder="Keyword">
        <p>Select Department: </p>
        <select id='department'>
          <option value=''>All</option>
          <option value="BSIT">BSIT</option>
          <option value="BSIS">BSIS</option>
          <option value="BACOMM">BACOMM</option>
          <option value="THM">THM</option>
          <option value="BSCOE">BSCOE</option>
        </select>
        <p>From: </p>
        <input type="date" value="" name="date_from">
        <p>To: </p>
        <input type="date" value="" name="date_to">
        <button class="go-filter">Filter</button>
      </form>
    </div>
  </div>

  <div id="profilePicture" class="mod">
    <div class="mod-content">
      <div class="mod-header">
        <p>Change Account Picture</p>
        <i class="close fa-solid fa-xmark"></i>
      </div>
      <form class="mod-message" action="../updateProfilePicture.php" method="post" enctype='multipart/form-data'>
        <img id='imgInpPreview' src='../<?php echo $userArray[0];?>'>
        <div class="mt-3 mb-3" style="width: 60%;">
          <input id="imgInp" class="form-control form-control-sm" type="file" name='newImage'>
        </div>
        <button class="mt-3 mb-3 btn btn-primary">
          Update
          <i class="fa-solid fa-check ms-1"></i>
        </button>
      </form>
    </div>
  </div>

  <div id="uploadForm" class="mod">
    <div class="mod-content-upload">
      <div class="mod-header">
        <p>Change Account Picture</p>
        <i class="close fa-solid fa-xmark"></i>
      </div>
      <form class="mod-message" action="../updateProfilePicture.php" method="post" enctype='multipart/form-data'>
        <img id='imgInpPreview' src='../<?php echo $userArray[0];?>'>
        <div class="mt-3 mb-3" style="width: 60%;">
          <input id="imgInp" class="form-control form-control-sm" type="file" name='newImage'>
        </div>
        <button class="mt-3 mb-3 btn btn-primary">
          Update
          <i class="fa-solid fa-check ms-1"></i>
        </button>
      </form>
    </div>
  </div>

  <main class="container-fluid g-0 " >
    <div id="bookmark-sidebar" class="sidebar">
      <div class="sidebar-header">
        <h6>My Saved Thesis</h6>
        <i onclick='closeBookmark()' class="fa fa-x"></i>
      </div>
      <div class="bookmark-holder">
      </div>
      
      <div class="mt-4 my-saved-thesis-mobile">
          <h6>My Thesis</h6>
          <div class="my-thesis">
            <?php
              $tables = ['pending', 'approved'];

              foreach ($tables as $item) {
                $checkmythesis = "SELECT * FROM {$item} WHERE unique_id='$userArray[3]'";
                $checkThesis = $conn -> query($checkmythesis);
                if(($checkThesis -> num_rows) > 0){
                  $selectOwnThesis = "SELECT * FROM {$item} WHERE unique_id='$userArray[3]'";
                  $ownThesis = $conn -> query($selectOwnThesis);
                  while($own = $ownThesis -> fetch_array()){
                    echo "
                    <h6>".$own['title']."</h6>
                    <p>Authors</p>
                    <div class='comembers-mobile'>";
                    $comember = $own['authors'];
                    $comember_exploded = explode('%%', $comember);
                    foreach($comember_exploded as $author){
                      $authorProfilePicture = $conn -> query("SELECT * FROM students WHERE name='$author'");
                      $auth_profile_picture = '';
                      
                      if(($authorProfilePicture -> num_rows) > 0){
                        while($pp = $authorProfilePicture -> fetch_array()){ 
                          $auth_profile_picture = $pp['profile_picture_url'];
                        }
                      }else {
                        $auth_profile_picture = 'files/default-user.png';
                      }
                      echo "<a class='member'>
                        <img src='../$auth_profile_picture'>
                        <p>$author</p>
                      </a> ";
                    }
                    
                    echo "
                    </div>
                    <p>Department</p>
                    <h6>".$own['department']."</h6>

                    <p>Publication Date</p>
                    <h6>".$own['publication_date']."</h6>
                    
                    <a href='../".$own['document_url']."'>View Document</a>
                    <p class='{$item}'>".$own['status']."</p> ";
                  }
                }
              }
            ?>
          </div>
      </div>
      

    </div>

    <div id="notification-sidebar" class="sidebar">
      <div class="sidebar-header">
        <h6>Notifications</h6>
        <i onclick='closeNotification()' class="fa fa-x"></i>
      </div>
      <div class="notifications-holder">
        <?php
          $getNotification = "SELECT notifications FROM $usertable WHERE email='".$_SESSION['email']."'";
          $notification = $conn -> query($getNotification);
          
          while($row = $notification -> fetch_array()){
            $notif = explode("%%", $row['notifications']);
            echo "<div class='notification'>
            <p>".$notif['0']."</p>
            <p>".$notif['1']."</p>
            </div>";
          }
          
        ?>
      </div>
    </div>

    <div id="account-sidebar" class="sidebar">
      <div class="sidebar-header">
        <h6>Account (<?php echo $_SESSION['role']; ?>)</h6>
        <i onclick='closeAccountSidebar()' class="fa fa-x"></i>
      </div>
      
      <div class="account-information">
        

        <img src="../<?php echo $userArray[0]; ?>">
        <p><?php echo $userArray['2']; ?></p>
        <p><?php echo $_SESSION['email']; ?></p>
        <h4><?php echo $_SESSION['department']; ?></h4>
      </div>
      <div class="account-options">
        <?php
          if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Coordinator'){
            echo "<a class='acct-action-button' href='../admin'>
            <i class='fa-regular fa-user-gear me-2'></i>
            Go to Admin Panel
          </a>";
          }
          if($_SESSION['role'] == 'Representative'){
            if($userArray[3] == 0){
              echo 
              "<a class='upload-button-mobile acct-action-button'>
                <i class='fa-duotone fa-arrow-up-from-bracket'></i>
                <p>Upload Thesis</p>
              </a>";
            }
          }
        ?>
        
        <a class='acct-action-button' onclick='openChangeProfilePicture()'">
          <i class="fa-regular fa-image"></i>
          <p>Change Account Picture</p>
        </a>
        <a class='acct-action-button' href="../signout.php">
          <i class="fa-regular fa-shield-check"></i>
          <p>View Privacy Policy</p>
        </a>
        <a class='acct-action-button' href="../signout.php">
          <i class="fa-regular fa-circle-question"></i>
          <p>Help</p>
        </a>
        <a class='acct-action-button' href="../signout.php">
          <i class="fa-regular fa-arrow-right-from-bracket"></i>
          <p>Signout</p>
        </a>
      </div>
      <div class="about">
        <p>Deposis v11.27.2022-95%</p>
      </div>
    </div>
    <header>
      <div class="header-mobile">
        <div class='header-mobile-top'>
          <a class="brand" href="../">
            <img src='../assets/deposis-white.png'>
          </a>
          <?php
          if(isset($_SESSION['role'])){
            echo "
            <div class='ms-3 profile-picture' onclick='openAccountSidebar()'>
              <img src='../".$userArray['0']."'>
            </div>";
            }
          ?>
        </div>
        <div class="header-mobile-search">
          <form class="search-form">
            <i class="fa-solid fa-magnifying-glass "></i>
            <input type="search" id='main-search' value='' placeholder='Start searching..'>
          </form>
        </div>
      </div>

      <div class="header-web">
        <a class="brand" href="../"><img src='../assets/deposis-white.png'></a>
        <form class="search-form-web">
          <i class="fa-solid fa-magnifying-glass "></i>
          <input type="search" id='main-search-web' value='' placeholder='Start searching..'>
          <a class="open-filter-modal">Filter</a>
        </form>

        <div class="action-buttons">
        <?php
            if($_SESSION['email'] == 'Guest'){
              echo "<a href='../signout.php'>Signout</a>";
            }
        ?>
        <?php
          if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 'Representative'){
              if($userArray[3] == 0){
                echo 
                "<button class='upload-button btn btn-light'>
                  <i class='fa-duotone fa-arrow-up-from-bracket me-2'></i>
                  Upload
                </button>";
              }else {
                echo 
                "<button class='view-my-thesis btn btn-light'>
                  View My Thesis
                </button>";
              }
            }

            echo 
            "<a class='ms-2' onclick='openNotification()'>
              <i class='fa-solid fa-bell fa-xl'></i>
            </a>
            <a class='ms-2' onclick='openBookmark()'>
              <i class='fa-solid fa-book-bookmark fa-xl'></i>
            </a>
            </div>
              <div class='ms-3 profile-picture' onclick='openAccountSidebar()'>
              <img src='../".$userArray['0']."'>
            </div>";
            }
        ?>
      </div>
      
      
    </header>
    <!-- Footer for Mobile View -->
    <div class="footer-mobile">
      <i onclick='openNotification()' class="fa-solid fa-bell fa-xl"></i>
      <i class="filter-button fa-solid fa-list fa-xl"></i>
      <i onclick='openBookmark()' class='fa-solid fa-book-bookmark fa-xl'></i>
    </div>
    <div class="wrapper">
      <aside>
      </aside>
      <article>
        <div class="sorter">
          <p>Sort by:</p>
          <a>A-Z</a>
          <a>Z-A</a>
          <a>Newest - Oldest</a>
          <a>Oldest - Newest</a>
        </div>
        <div class="sorter">
          <p>Category:</p>
          <div class="category-list">
            <a href="index.php?category=Game">Game <?php 
              $gameCount = $conn -> query("SELECT * FROM approved WHERE category='Game'");
              echo $gameCount -> num_rows;
            ?></a>
            <a href="index.php?category=Web">Web
            <?php 
              $gameCount = $conn -> query("SELECT * FROM approved WHERE category='Web'");
              echo $gameCount -> num_rows;
            ?>
            </a>
            <a href="index.php?category=Mobile">Mobile
            <?php 
              $gameCount = $conn -> query("SELECT * FROM approved WHERE category='Mobile'");
              echo $gameCount -> num_rows;
            ?>
            </a>
          </div>
        </div>

        <div class="thesis-result-container">
          <?php
            while($thesis = $theses -> fetch_array()){
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
                <p>Approved on: ".$thesis['approved_date']."</p>
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
                <p class='pub_date'>".$thesis['department'].", ".$thesis['publication_date']."</p>
              </div>";
              }
              echo "</div>";
            }
          ?> 
          <br><br><br>
        </div>
        <style>
          
        </style>
      </article>
    </div>
  </main>
  <div id='snackbar'></div>
  <script src="../js/jquery.js"></script>
  <script>
    <?php 
      if(isset($_GET['success'])){
        echo "myFunction('".$_GET['success']."');";
      }
    ?>

    function myFunction(message) {
      var x = $('#snackbar');

      x.addClass('show');
      x.html(message)

      setTimeout(function(){ x.removeClass('show') }, 3000);
    }

    
  </script>
</body>
</html>

