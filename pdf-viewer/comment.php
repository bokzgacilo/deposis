<?php
  session_start();
  include('../connection.php');

  $new_comment = $_POST['comment'];
  $thesis = $_POST['file'];

  $selectThesis = "SELECT * FROM approved WHERE unique_id=$thesis";
  $selected = $conn -> query($selectThesis);
  $updateComment = '';
  
  while($row = $selected -> fetch_array()){
    $comment = $row['comments'];

    if($comment == ''){
      $updateComment = $_SESSION['email'] . '$$$' . $new_comment . '$$$' . date("Y-m-d");
    }else {
      $updateComment = $comment . '%%' . $_SESSION['email'] . '$$$' . $new_comment . '$$$' . date("Y-m-d");
    }    
  }
  $finalize = $conn -> real_escape_string($updateComment);
  $updateComment = "UPDATE approved SET comments='".$finalize."' WHERE unique_id=$thesis";
  
  echo 'success';
  $conn -> query($updateComment);

  $conn -> close();
?>