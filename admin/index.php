<?php
  session_start();

  
  if(preg_match("/(Admin|Coordinator)/i", $_SESSION['role'])){
    $table = '';

    if(!isset($_GET['page'])){

      if($_SESSION['role'] == 'Coordinator'){
        header('location: index.php?page=students');
      }

      if($_SESSION['role'] == 'Admin'){
        header('location: index.php?page=faculty');
      }

    }else {
      $table = $_GET['page'];
    }
  }else {
    header('location: ../search/index.php?error=Access Denied');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Online search engine for thesis of STI Global City.">
  <title>Dashboard - Deposis</title>
  <script src="../bootstrap 5.2/js/bootstrap.min.js"></script>
  <script src="../js/jquery.js"> </script>
  <script src="script.js"> </script>
  <link rel="stylesheet" href="../css/base.css">
  <link rel='stylesheet' href='style.css'>
</head>
<body>
  <div class="viewport-checker">
    <img src="../assets/deposis.png" class="deposis">
    <p>Admin Panel is available on web desktop view only.</p>
    <a href='../'>Back to search</a>
  </div>
  <div id="single-data" class="mod">
    <div class="mod-content">
      <div class="mod-header">
        <p>Add Single Data</p>
        <i class="close fa-solid fa-x"></i>
      </div>
      <form action="add-single-data.php" method="post" enctype="multipart/form-data" class="mod-message">
        <select name='target' class="form form-control">
          <option>Students</option>
          <option>Faculty</option>
        </select>
        <input type='email' name='email' class="mt-2 form form-control" placeholder='Email' required>
        <input type='text' name='name' class="mt-2 form form-control" placeholder='Fullname (Dela Cruz, Juan)' required>
        <select name='department' class="mt-2 form form-control">
          <option>IT</option>
          <option>BACOMM</option>
          <option>DBAA</option>
          <option>THM</option>
          <option>BCAA</option>
          <option>CPE</option>
          <option>SHS</option>
        </select>
        <button class="mt-2 btn btn-primary" type="submit" name='submit'>Add</button>
      </form>
    </div>
  </div>

  <div id="report_modal" class="mod">
    <div class="mod-content">
      <div class="mod-header">
        <p>Generate Report</p>
        <i class="close fa-solid fa-x"></i>
      </div>
      <form action="generate_report.php" method="post" enctype="multipart/form-data" class="mod-message">
        <select class="form form-control" name='reports' id="reports">
          <option value='1'>List of Theses</option>
          <option value='2'>List of Faculty</option>
          <option value='3'>List of Coordinators</option>
          <option value='4'>List of Students</option>
          <option value='5'>List of Representative</option>
          <option value='6'>Generate login report</option>
        </select>
        <button class="mt-2 btn btn-primary" type="submit" name='submit'>Download Report</button>
      </form>
    </div>
  </div>

  <div id="importModal" class="mod">
    <div class="mod-content">
      <div class="mod-header">
        <p>Import Faculty (.xlxs)</p>
        <i class="close fa-solid fa-x"></i>
      </div>
      <form class="mod-message" action="import.php?target=faculty" method="post" enctype='multipart/form-data'>
        <div class="input-file-container">  
          <input class="input-file" name="file" type="file">
          <label tabindex="0" for="my-file" class="input-file-trigger">Select a file...</label>
        </div>
        <button class="mt-2 btn btn-primary" type="submit" name="submit">Import</button>
      </form>
    </div>
  </div>

  <div id="importStudent" class="mod">
    <div class="mod-content">
      <div class="mod-header">
        <p>Import Students (.xlxs)</p>
        <i class="close fa-solid fa-x"></i>
      </div>
      <form class="mod-message" action="import.php?target=students" method="post" enctype='multipart/form-data'>
        <div class="input-file-container">  
          <input class="input-file" name="file" type="file">
          <label tabindex="0" for="my-file" class="input-file-trigger">Select a file...</label>
        </div>
        <button class="mt-2 btn btn-primary" type="submit" name="submit">Import</button>
      </form>
    </div>
  </div>

  <div class="admin-container">
    <aside class="sidebar">
      <img src="../assets/deposis.png" class="deposis">
      <h5 class="mt-4 mb-2 align-self-center">Menu</h5>

      <?php
        if($_SESSION['role'] != 'Coordinator'){
          echo "
          <a href='../blank-template.xlsx' >Download Blank Temaplatec</a>
          <a class='generate-report' >
            <i class=' fa-solid fa-file-export me-2'></i>
            <span id='button-text'>Generate Report</span>
          </a>
          <a class='add-single-data'>
            <i class='fa-solid fa-plus me-2'></i>
            <span id='button-text'>Add Single Data (Faculty)</span>
          </a>
          <a class='import-student'>
            <i class='fa-solid fa-plus me-2'></i>
            <span id='button-text'>Import Faculty List (XLXS)</span>
          </a>
          <a href='index.php?page=faculty'>
            <i class='fa-solid fa-chalkboard-user me-2'></i>
            <span id='button-text'>Faculty</span>
          </a>
          ";
        }
      if($_SESSION['role'] == 'Coordinator'){
        echo "
        <a href='../blank-template.xlsx' > Download Blank Template</a>
        <a class='add-single'>
          <i class='fa-solid fa-plus me-2'></i>
          <span id='button-text'>Add Single Data (Student)</span>
        </a>
        <a class='import-student'>
          <i class='fa-solid fa-plus me-2'></i>
          <span id='button-text'>Import Student List (XLXS)</span>
        </a>
        ";
      }
      ?>  
      <a class="navigator" href="index.php?page=students">
        <i class="fa-solid fa-screen-users me-2 " ></i>
        <span id='button-text'>Students</span>
      </a>
      <a  href="index.php?page=pending">
        <i class="fa-regular fa-box-archive ms-1 me-3"></i>
        <span id='button-text'>Pending</span>
      </a>
      <?php
        if($_SESSION['role'] != 'Coordinator'){
          echo "
          <a href='index.php?page=approved'>
            <i class='fa-solid fa-check ms-1 me-3'></i>
            <span id='button-text'>Approved</span>
          </a>
          ";
        }
      ?>
      <div class="about">
        <p>Deposis v10.25.2022-90%</p>
      </div>
    </aside>
    <main>
      <header>
        <form class="search-form">
          <i class="fa-solid fa-magnifying-glass ms-2 me-3"></i>
          <input type="search" placeholder="Search name" id='search'>
          <div class="filter ">
            <i  class="fa-duotone fa-list ms-2 me-2 fa-xl"></i>
          </div>
        </form>
      </header>
      <div class="wrapper">
        <div class="table-container">
          <div class="controller">
            <?php 
              if($table == 'faculty' && $_SESSION['role'] == 'Admin'){
                echo "
                <a class='coordinator thesis-controller'>
                  <i class='me-2 fa-regular fa-circle-check'></i>
                  <p>Make Coordinator</p>
                </a>
                ";
              }

              if($table == 'students' && $_SESSION['role'] == 'Coordinator'){
                echo "
                <a class='representative thesis-controller'>
                  <i class='me-2 fa-regular fa-circle-check'></i>
                  <p>Make Representative</p>
                </a>
                ";
              }

              if($table == 'pending' && $_SESSION['role'] == 'Coordinator'){
                echo "
                <a class='approve thesis-controller'>
                  <i class='me-2 fa-regular fa-circle-check'></i>
                  <p>Approved</p>
                </a>
                ";
              }

              if($table == 'approved' && $_SESSION['role'] == 'Admin'){
                echo "
                <a class='archive thesis-controller '>
                  <i class='me-2 fa-regular fa-box-archive'></i>
                  <p>Archive</p>
                </a>
                ";
              }
            ?>
          </div>
          <table id='customers'>
            <tr>
              <th class="table-action-menu">
                <input type="checkbox" class="larger me-3">
                <i class="fa-solid fa-arrows-rotate refresh me-3"></i>
                <i class="deleteButton fa-solid fa-trash me-3"></i>
              </th>
            </tr>
            <tr class="result-table">
              <!-- Render table data -->
            </tr>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>