<?php
  include('../connection.php');

  $title = $_GET['thesis'];
  $getThesis = $conn -> query("SELECT * FROM approved WHERE title='$title'");

  while($row = $getThesis -> fetch_array()){
    $authors =  explode("%%", $row['authors']);
    $commentHeader = '';

    if($row['comments'] != ''){
      $commentHeader =  explode("%%", $row['comments']);
    }
    // $commentHeader = $row['comments'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="../css/base.css">
</head>
<body>
  <style>
  
  </style>
  <div class="reader">
    <?php
    
    echo "<object
    style='pointer-events: none;'
    data='../".$row['document_url']."#&toolbar=0'
    type='application/pdf'
    oncontextmenu='return false';
    >
      <p>Document was not properly loaded. Please contact the administrator for further actions. Thank you!</p>
    </object>";
    ?>
  </div>

  <div class="wrapper">
    <aside>
      <a href='../search/' class="btn btn-primary mb-2">Back</a>
      <div class="thesis-info">
        <h4 class="mb-3"><?php echo $title;?></h4>
        <h5 class="mb-4">Authors <?php echo count($authors); ?></h5>
        <div class="authors">
          <?php
            foreach($authors as $author){
              echo "<a class='author'>
                <img src='../assets/default-user.png'>
                $author
              </a>";
            }
          ?>
        </div>
        <h6 class="f16 mt-4">Comments <?php if($commentHeader != ''){
          echo count($commentHeader);
        } ?></h6>
        <div class="comment-section">
          <?php
            if($commentHeader == ''){
              echo "<p>No comments available.</p>";
            }else {
              $user_dp = '';
              $user_name = '';

              foreach($commentHeader as $commentBody){
                $commentBody = explode('$$$', $commentBody);
                $target_email = $commentBody['0'];

                $area = ['faculty', 'students', 'admin'];
                $table = '';
                $checker = '';
                foreach ($area as $org) {
                  $query = $conn -> query("SELECT * FROM $org WHERE email='$target_email'");
                  if(($query -> num_rows) > 0){
                    $table = $org;
                    break;
                  }
                }

                $selectUser = $conn -> query("SELECT * FROM $table WHERE email='$target_email'");
                while($user = $selectUser -> fetch_array()){
                  $user_dp = $user['profile_picture_url'];
                  $user_name = $user['name'];
                }

                // echo  $user_dp;
                echo "<div class='comment'>
                  <img src='../$user_dp'>
                  <div>
                    <p class='commentor'>".$user_name."</p>
                    <p class='comment-message'>".$commentBody['1']."</p>
                  </div>
                </div>";
              }
            }
            
          ?>
        </div>
        <form class="d-flex flex-row mp-2 mb-4" action='comment.php?thesis=<?php echo $title;?>' method="post">
          <input type="text" class="form-control me-2" placeholder='Comment' name='comment'>
          <button name="send" class='btn btn-primary' type="submit">Post</button>
        </form>
      </div>
    </aside>
    <main>
      <?php 
          echo "
          <iframe
            src='../".$row['document_url']."#toolbar=0'
            width='100%';
            height='100%';
            style='border:none;'
            ></iframe>
          ";

          // echo "<object
          //   style='pointer-events: none;'
          //   data='../".$row['document_url']."#&toolbar=0'
          //   type='application/pdf'
          //   oncontextmenu='return false';
          // >
          //   <p>Document was not properly loaded. Please contact the administrator for further actions. Thank you!</p>
          // </object>";
      ?>
    </main>
  </div>
</body>
</html>

<?php
}
?>