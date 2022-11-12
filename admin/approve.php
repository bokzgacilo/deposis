<?php
  session_start();

  include('../connection.php');

  $id = $_POST['id'];

  foreach ($id as $entry) {
    $transfer = "INSERT INTO approved SELECT * FROM pending WHERE unique_id='$entry'";
    $conn -> query($transfer);

    $delete = "DELETE FROM pending WHERE unique_id='$entry'";
    $conn -> query($delete);
  }

  $conn -> close();
?>