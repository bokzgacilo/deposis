<?php
  session_start();

  include('../connection.php');

  $unique_id = $_POST['unique_id'];
  $table = $_SESSION['table'];
  $email = $_SESSION['email'];
  $oldBookmark = '';
  $updatedBookmark = '';

  $selectUser = "SELECT saved_thesis FROM $table WHERE email='$email'";
  $saved = $conn -> query($selectUser);

  
  while($r = $saved -> fetch_array()){
    $oldBookmark = $r['saved_thesis'];
  }

  if($oldBookmark == ''){
    $updatedBookmark = $unique_id;
  }else {
    $updatedBookmark = $unique_id . "%%" . $oldBookmark;
  }

  $update = "UPDATE $table SET saved_thesis='$updatedBookmark' WHERE email='$email'";
  $conn -> query($update);
  $conn -> close();

?>