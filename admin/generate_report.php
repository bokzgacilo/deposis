<?php
  session_start();
  include('../connection.php');

  $report = $_POST['reports'];
  $sql = '';
  $filename = '';

  switch($report){
    case 1:
      $filename = "list_of_theses.xls";
      echo "
      <table>
        <thead>
          <tr>
            <th></th>
            <th>ID</th>
            <th>Title</th>
            <th>Authors</th>
            <th>Department</th>
            <th>Publication Date</th>
            <th>Uploaded Date</th>
          </tr>
        </thead>
        <tbody>";
        $no = 1;
        $sql = "SELECT * FROM approved";     
        $advresult = $conn -> query($sql);
        while ($row = $advresult -> fetch_assoc()) {
        echo "
        <tr>
          <td>$no</td>
          <td>".$row['unique_id']."</td>
          <td>".$row['title']."</td>
          <td>";
            $authors = explode('%%', $row['authors']);
            foreach ($authors as $name) {
              echo $name . ', ';
            }
          echo "</td>
          <td>".$row['department']."</td>
          <td>".$row['publication_date']."</td>
          <td>".$row['uploaded_date']."</td>
          </tr>"; 
          $no++;
        }
        echo "</tbody>
      </table>";
      break;
    case 2:
      $filename = "list_of_faculty.xls";
      echo "
      <table>
        <thead>
          <tr>
            <th></th>
            <th>Email</th>
            <th>Fullname</th>
            <th>Department</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>";
        $no = 1;
        $sql = "SELECT * FROM faculty";     
        $advresult = $conn -> query($sql);
        while ($row = $advresult -> fetch_assoc()) {
        echo "
        <tr>
          <td>$no</td>
          <td>".$row['email']."</td>
          <td>".$row['name']."</td>
          <td>".$row['department']."</td>
          <td>".$row['role']."</td>
        </tr>"; 
        $no++;
        }
        echo "</tbody>
      </table>";
      break;
    case 3:
      $filename = "list_of_coordinators.xls";
      echo "
      <table>
        <thead>
          <tr>
            <th></th>
            <th>Email</th>
            <th>Fullname</th>
            <th>Department</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>";
        $no = 1;
        $sql = "SELECT * FROM faculty WHERE role='Coordinator'";     
        $advresult = $conn -> query($sql);
        while ($row = $advresult -> fetch_assoc()) {
        echo "
        <tr>
          <td>$no</td>
          <td>".$row['email']."</td>
          <td>".$row['name']."</td>
          <td>".$row['department']."</td>
          <td>".$row['role']."</td>
        </tr>"; 
        $no++;
        }
        echo "</tbody>
      </table>";
      break;
    case 4:
      $filename = "list_of_students.xls";
      echo "
      <table>
        <thead>
          <tr>
            <th></th>
            <th>Email</th>
            <th>Fullname</th>
            <th>Department</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>";
        $no = 1;
        $sql = "SELECT * FROM students";     
        $advresult = $conn -> query($sql);
        while ($row = $advresult -> fetch_assoc()) {
        echo "
        <tr>
          <td>$no</td>
          <td>".$row['email']."</td>
          <td>".$row['name']."</td>
          <td>".$row['department']."</td>
          <td>".$row['role']."</td>
        </tr>"; 
        $no++;
        }
        echo "</tbody>
      </table>";
      break;
    case 5:
      $filename = "list_of_representative.xls";
      echo "
      <table>
        <thead>
          <tr>
            <th></th>
            <th>Email</th>
            <th>Fullname</th>
            <th>Department</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>";
        $no = 1;
        $sql = "SELECT * FROM students WHERE role='Representative'";     
        $advresult = $conn -> query($sql);
        while ($row = $advresult -> fetch_assoc()) {
        echo "
        <tr>
          <td>$no</td>
          <td>".$row['email']."</td>
          <td>".$row['name']."</td>
          <td>".$row['department']."</td>
          <td>".$row['role']."</td>
        </tr>"; 
        $no++;
        }
        echo "</tbody>
      </table>";
      break;
    case 6:
      echo 'f';
      break;
  }

  header('Content-type: application/vnd-ms-excel');
  header("Content-Disposition:attachment;filename=\"$filename\"");

  $conn -> close();
?>