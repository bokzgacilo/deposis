<?php
  session_start();

  require "vendor/autoload.php";

  use myPHPnotes\Microsoft\Auth;

  $tenant = "ac848b9f-db81-4f90-8617-684472457a47";
  $client_id = "c7b9a796-9761-4942-b182-12da167e9ed7";
  $client_secret = "7y28Q~bUSBuzTrmT2OOCVYd4_Oba9MvhXKEWWdqy";

  // DEVELOPMENT
  // $callback = "http://localhost/deposis/callback.php"; 

// EXPOSE
  // $callback = "https://dzite4-ip-152-32-99-99.expose.sh/deposis/callback.php"; 

  // PROD
  $callback = "https://deposis.online/callback.php";
  $scopes = ["User.Read"];

  $microsoft = new Auth($tenant, $client_id, $client_secret, $callback, $scopes);

  header("location: " . $microsoft -> getAuthUrl());
?>