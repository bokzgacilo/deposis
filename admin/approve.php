<?php
  session_start();

  include('../connection.php');

  $id = $_POST['id'];

  $date = date('d-m-y');
  echo $date;

  foreach ($id as $entry) {
    $transfer = "INSERT INTO approved SELECT * FROM pending WHERE unique_id='$entry'";
    $conn -> query($transfer);
    $conn -> query("UPDATE approved SET status='Approved' WHERE unique_id='$entry'");
    $conn -> query("UPDATE approved SET approved_date='$date' WHERE unique_id='$entry'");
    $conn -> query("DELETE FROM pending WHERE unique_id='$entry'");
  }

  $conn -> close();
?>