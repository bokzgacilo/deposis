<?php

  include('../connection.php');
  $id = $_POST['id'];

  foreach ($id as $user_id) {
    $sql = "UPDATE faculty SET role='Coordinator' WHERE id='$user_id'";
    $conn -> query($sql);

  echo 'updated';

  }

  $conn -> close();
  // print_r($id);
?>