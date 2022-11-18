<?php
  require_once '../vendor/autoload.php';
  include('../connection.php');
  include('../emailer.php');

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Reader\Csv;
  use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
  
  $table = $_GET['target'];
  if (isset($_POST['submit'])) {
    $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
    
      $arr_file = explode('.', $_FILES['file']['name']);
      $extension = end($arr_file);
    
      if('csv' == $extension) {
          $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
      } else {
          $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      }

      $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
      $sheetData = $spreadsheet -> getActiveSheet() -> toArray();
        
      if (!empty($sheetData)) {
        for ($i = 0; $i < count($sheetData); $i++) {
          $email = $sheetData[$i][0];  
          $name = $sheetData[$i][1];
          $dept = $sheetData[$i][2];

          $domain = "/(globalcity.sti.edu.ph)/";

          if (preg_match($domain, $email)) {
            $checkDatabase = "SELECT * FROM $table WHERE email='$email'";
            $checker = $conn -> query($checkDatabase);

            if($row = $checker -> fetch_array()){
              echo $name . ' was already existing. <br>';
            }else {
              sendRegistrationEmail($email, $name);
              $account_created = date('Y-m-d H:i:s');
              $message = "Account Created%%" . date('Y-m-d H:i:s');
              $sql = "INSERT INTO $table (email, name, department, account_created, notifications) VALUES('$email', '$name', '$dept', '$account_created', '$message')";

              if (mysqli_query($conn, $sql)) {
                echo $name . ' was added. <br>';
              }
            }
          }else {
            echo $name . ' email is not a STI Global City account.<br>';
          }
        }
        echo "<a href='index.php'>Back to dashboard</a>";
      }
    }else {
      echo "Invalid file format, please try again <a href='index.php'>Back</a>";
    }
  }
?>