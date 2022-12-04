<?php
  include('../connection.php');
  session_start();
  
  $authors = implode('%%', $_POST['authors']);
  $title = $_POST['title'];
  $abstract = $_POST['abstract'];
  $department = $_SESSION['department'];
  $publication_date = $_POST['pubdate'];
  $category = $_POST['category'];
  $unique_id = rand(00000, 99999);
  $filename = $_FILES['soft_copy']['name'];
  $temp_name = $_FILES['soft_copy']['tmp_name'];
  $year = date('Y', strtotime($publication_date));

  if($year < 2015){
    echo 0;
  }else {
    $user = $_SESSION['email'];

    $author_array = explode('%%', $authors);
    foreach ($author_array as $author) {
        $conn -> query("UPDATE students SET unique_id='$unique_id' WHERE name='$author'");
        $conn -> query("UPDATE students SET unique_id='$unique_id' WHERE email='$user'");
    }

    $destination = '../files/document/';
    
    $docURL = 'files/document/'.$filename;

    move_uploaded_file($temp_name, $destination . $filename);
        
    $sql = "INSERT INTO pending (unique_id, title, abstract, authors, department, publication_year, publication_date, status, uploaded_date, document_url, category) 
            VALUES (
                $unique_id,
                '$title',
                '$abstract',
                '$authors',
                '$department',
                '$publication_year',
                '$publication_date',
                'Pending',
                NOW(),
                '$docURL',
                '$category'
            );";
    if(!$conn -> query($sql)){
      // Failed
      echo 2;
    }else {
      // Success
      echo 3;
    }

    $conn -> close();
  }
?>