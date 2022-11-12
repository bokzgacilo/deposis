<?php
  session_start();

  include('../connection.php');

  $table = $_SESSION['table'];
  $email = $_SESSION['email'];

  $bookmark = '';

  $selectUser = "SELECT saved_thesis FROM $table WHERE email='$email'";
  $saved = $conn -> query($selectUser);

  
  while($r = $saved -> fetch_array()){
    $bookmark = $r['saved_thesis'];
  }

  if($bookmark == ''){
    echo "<p>Nothing to show here.</p>";
  }else {
    $bookmark = explode('%%', $bookmark);
    foreach ($bookmark as $book) {
      $sql = $conn -> query("SELECT title, document_url FROM approved WHERE unique_id='$book'");
      while($r = $sql -> fetch_array()){
        $title = $r['title'];
        $document_url = $r['document_url'];
        echo "<a href='../$document_url'>$title</a>";
      }
    }
  }

  $conn -> close();
?>