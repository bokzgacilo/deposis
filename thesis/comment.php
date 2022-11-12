<?php
  session_start();
  include('../connection.php');

  $new_comment = $_POST['comment'];
  $thesis = $_GET['thesis'];
  
  $selectThesis = "SELECT * FROM approved WHERE title='$thesis'";
  $selected = $conn -> query($selectThesis);

  $updateComment = '';
  
  while($row = $selected -> fetch_array()){
    echo $row['comments'];
    $comment = $row['comments'];

    if($comment == ''){
      $updateComment = $_SESSION['email'] . '$$$' . $new_comment . '$$$' . date("Y-m-d");
    }else {
      $updateComment = $comment . '%%' . $_SESSION['email'] . '$$$' . $new_comment . '$$$' . date("Y-m-d");
    }

    
  }
  $finalize = $conn -> real_escape_string($updateComment);
  $updateComment = "UPDATE approved SET comments='".$finalize."' WHERE title='$thesis'";
  $conn -> query($updateComment);
  header('location: view.php?thesis=' . $thesis);
  $conn -> close();
?>