<?php
  include('../connection.php');
  $table = $_POST['table'];

  if(isset($_POST["id"])) {
  foreach($_POST["id"] as $id) {
    $conn -> query("DELETE FROM $table WHERE id= '".$id."'");
  }
}

?>