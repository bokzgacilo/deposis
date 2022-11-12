<?php 
  session_start();
  
  include('connection.php');
  // include('emailer.php');

  require "vendor/autoload.php";

  use myPHPnotes\Microsoft\Auth;
  use myPHPnotes\Microsoft\Handlers\Session;
  use myPHPnotes\Microsoft\Models\User;

  $auth = new Auth(Session::get("tenant_id"), Session::get("client_id"), Session::get("client_secret"), Session::get("redirect_uri"),
  Session::get("scopes"));

  $tokens = $auth -> getToken($_REQUEST['code']);
  $accessToken = $tokens -> access_token;

  $auth -> setAccessToken($accessToken);

  $user = new User;

  $email = $user -> data -> getUserPrincipalName();

  $area = ['faculty', 'students', 'admin'];
  $table = '';
  $checker = '';
  
  foreach ($area as $org) {
    $check = "SELECT * FROM $org WHERE email='$email'";
    $checker = $conn -> query($check);

    if(($checker -> num_rows) > 0){
      $table = $org;
      break;
    }else {
      $_SESSION['email'] = 'Guest';
      $_SESSION['table'] = 'students';
    }
  }



  while($row = $checker -> fetch_array()){
    $_SESSION['department'] = $row['department'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['table'] = $table;
  }

  // echo $_SESSION['email'];
  // echo "<a href='signout.php'>signout</a>";
  header('location: search/');
  $conn -> close();
?>
