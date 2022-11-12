<?php
  session_start();

  include('../connection.php');

  $id = $_POST['id'];

  foreach ($id as $entry) {
    $transfer = "INSERT INTO pending SELECT * FROM approved WHERE unique_id='$entry'";
    $conn -> query($transfer);

    $delete = "DELETE FROM approved WHERE unique_id='$entry'";
    $conn -> query($delete);
  }

  $conn -> close();
?>