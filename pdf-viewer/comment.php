<?php
  session_start();
  include('../connection.php');


  // $find_letters = array('idiot', 'stupid');
  // $word = ['stupid', 'idiot'];
  $new_comment = $_POST['comment'];
  
  
  if(preg_match("/(idiot|stupid|penis|tite)/i", $new_comment)){
    echo 0;
  }else {
    $thesis = $_POST['file'];

    $selectThesis = "SELECT * FROM approved WHERE unique_id=$thesis";
    $selected = $conn -> query($selectThesis);
    $updateComment = '';
    
    while($row = $selected -> fetch_array()){
      $comment = $row['comments'];
  
      if($comment == ''){
        $updateComment = $_SESSION['email'] . '$$$' . $new_comment . '$$$' . date("Y-m-d");
      }else {
        $updateComment = $comment . '%%' . $_SESSION['email'] . '$$$' . $new_comment . '$$$' . date("Y-m-d");
      }    
    }
    $finalize = $conn -> real_escape_string($updateComment);
    $updateComment = "UPDATE approved SET comments='".$finalize."' WHERE unique_id=$thesis";
    
    echo 1;
    $conn -> query($updateComment);
  }

  // if(str_contains($new_comment, $find_letters, 1) !== false){
  //   echo 0;
  // }else {
    
  // }

  

  $conn -> close();
?>