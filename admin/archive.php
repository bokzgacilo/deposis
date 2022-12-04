<?php
  session_start();

  include('../connection.php');

  $id = $_POST['id'];

  foreach ($id as $entry) {
    $transfer = "INSERT INTO pending SELECT * FROM approved WHERE unique_id='$entry'";
    $conn -> query($transfer);

    $conn -> query("UPDATE pending SET status='Pending' WHERE unique_id='$entry'");
    $conn -> query("UPDATE approved SET approved_date='' WHERE unique_id='$entry'");
    $delete = "DELETE FROM approved WHERE unique_id='$entry'";
    $conn -> query($delete);
  }

  $conn -> close(); 
?>