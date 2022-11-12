<?php

  include('../connection.php');
  $id = $_POST['id'];

  foreach ($id as $user_id) {
    $sql = "UPDATE students SET role='Representative' WHERE id='$user_id'";
    $conn -> query($sql);

  echo 'updated';

  }

  $conn -> close();
  // print_r($id);
?>