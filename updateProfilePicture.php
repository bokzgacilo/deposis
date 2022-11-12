<?php 
  session_start();
  include('connection.php');

  $picture_url = '';

  if($_FILES['newImage']['tmp_name'] == ''){
    header('location: search/');
  }else {
    $extension  = pathinfo( $_FILES["newImage"]["name"], PATHINFO_EXTENSION );
    $temp_name = $_FILES['newImage']['tmp_name'];
    $basename = $_SESSION['name'] . "." . $extension;

    $picture_url = "files/user/" . $basename;
    $destination  = "files/user/{$basename}";

    move_uploaded_file($temp_name, $destination);

    $update = "UPDATE ".$_SESSION['table']." SET profile_picture_url='$picture_url' WHERE email='".$_SESSION['email']."'";
    $conn -> query($update);
    $conn -> close();
    
    if($targetTable == 'Admin'){
      header('location: ../admin/dashboard.php?success=Profile picture was successfully changed');
    }else {
      header('location: search/index.php?success=Profile picture was successfully changed');
    }
  }

  
?>