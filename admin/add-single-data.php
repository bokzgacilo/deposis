<?php
  include('../connection.php');
  include('../emailer.php');

  $email = $_POST['email'];
  $name = $_POST['name'];
  $department = $_POST['department'];
  $target = $_POST['target'];


  function validate($email) {
    $validEmail = array('globalcity.sti.edu.ph');
    $parts = explode('@',$email);
    $domain = $parts[1];
    if(in_array($domain, $validEmail)){
      return true;
    }else {
      return false;
    }
  }
  
  if(validate($email) == true){
    $area = ['faculty','students','admin'];
    $counter = 0;

    foreach ($area as $table) {
      $check = "SELECT * FROM {$table} WHERE email='$email'";
      $checkres = $GLOBALS['conn'] -> query($check);
      
      if(($checkres -> num_rows) > 0){
        $counter = $counter + 1;
      }
    } 

    if($counter <= 0){
      sendRegistrationEmail($email, $name);
      $date_time_now = date('Y-m-d H:i:s');
      $notification = "Account Created%%" . $date_time_now;
      $sql = "INSERT INTO {$target} (email, name, department, account_created, notifications)
      VALUES ('$email', '$name', '$department', '$date_time_now', '$notification')";
      $result = $GLOBALS['conn'] -> query($sql);
      echo "Account successfully created. <a href='index.php'>Back to dashboard</a>";
    }

  }else {
    echo 'invalid email';
  }

  $conn -> close();
?>