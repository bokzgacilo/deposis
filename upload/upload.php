<?php
  include('../connection.php');
  session_start();
  
  $authors = implode('%%', $_POST['authors']);
  echo $authors;      
  $title = $_POST['title'];
  $abstract = $_POST['abstract'];
  $department = $_SESSION['department'];
  $publication_date = $_POST['pubdate'];
  $unique_id = rand(00000, 99999);
  $filename = $_FILES['soft_copy']['name'];
  $temp_name = $_FILES['soft_copy']['tmp_name'];

  $destination = '../files/document/';
  
  $docURL = 'files/document/'.$filename;

  move_uploaded_file($temp_name, $destination . $filename);
  $sql = "INSERT INTO pending (unique_id, title, abstract, authors, department, publication_date, uploaded_date, document_url) 
          VALUES (
              $unique_id,
              '$title',
              '$abstract',
              '$authors',
              '$department',
              '$publication_date',
              NOW(),
              '$docURL'
          );";
  if(!$conn -> query($sql)){
    header('location: index.php?error=upload failed.');
  }else {
    header("Location:index.php?upload=success");
  }

  $conn -> close();
?>