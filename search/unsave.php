<?php
  session_start();

  include('../connection.php');

  $unique_id = $_POST['unique_id'];
  $table = $_SESSION['table'];
  $email = $_SESSION['email'];
  $bookmark = '';
  $updatedBookmark = '';

  $selectUser = "SELECT saved_thesis FROM $table WHERE email='$email'";
  $saved = $conn -> query($selectUser);

  
  while($r = $saved -> fetch_array()){
    $bookmark = $r['saved_thesis'];
  }
  $bookmark = explode('%%', $bookmark);
  $processed = array_diff($bookmark, array($unique_id));
  $updatedBookmark = implode('%%', $processed);
  // print_r($updatedBookmark);

  $update = "UPDATE $table SET saved_thesis='$updatedBookmark' WHERE email='$email'";
  $conn -> query($update);
  $conn -> close();

?>