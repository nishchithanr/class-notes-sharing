<?php
session_start();
$teacherID = $_SESSION['teacherID'];

$conn = mysqli_connect('localhost', 'root', '', 'classmate');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['btn-upload-notes'])){
  $input_title = $_POST['txt_title'];
  $input_chapter = (int) $_POST['txt_chapter'];
  $input_subject = $_POST['txt_subject'];

  $file_name = rand(1000,10000)."-".$_FILES['txt_notes_file']['name'];

  $temp_name = $_FILES['txt_notes_file']['tmp_name'];
  $upload_dir = "Notes_Files/";
  move_uploaded_file($temp_name,$upload_dir . $file_name);

  $sql = "INSERT INTO tbl_notes (Title, Chapter, Subject_ID, Notes_File) VALUES ('$input_title',$input_chapter,'$input_subject','$file_name')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Notes successfully uploaded !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

if(isset($_POST['btn-upload-assignment'])){
  $input_subject = $_POST['txt_subject'];
  $input_title = $_POST['txt_title'];
  $input_sdate = $_POST['txt_sdate'];

  $file_name = rand(1000,10000)."-".$_FILES['txt_assignment_file']['name'];

  $temp_name = $_FILES['txt_assignment_file']['tmp_name'];
  $upload_dir = "Notes_Files/";
  move_uploaded_file($temp_name,$upload_dir . $file_name);


  $sql = "INSERT INTO tbl_assignment (Title, Submission, Subject_ID, Teacher_ID, Assignment_File) VALUES ('$input_title','$input_sdate','$input_subject','$teacherID','$file_name')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Assignment successfully uploaded !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

if(isset($_POST['btn-upload-qb'])){
  $input_subject = $_POST['txt_subject'];
  $input_year = $_POST['txt_year'];

  $file_name = rand(1000,10000)."-".$_FILES['txt_qb_file']['name'];

  $temp_name = $_FILES['txt_qb_file']['tmp_name'];
  $upload_dir = "Notes_Files/";
  move_uploaded_file($temp_name,$upload_dir . $file_name);


  $sql = "INSERT INTO tbl_qb (Year, Subject_ID, Qb_File) VALUES ('$input_year','$input_subject','$file_name')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Question paper successfully uploaded !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

if(isset($_POST['btn-upload-reference'])){
  $input_subject = $_POST['txt_subject'];
  $input_title = $_POST['txt_title'];
  $input_chapter = $_POST['txt_chapter'];
  $input_link = $_POST['txt_link'];

  $sql = "INSERT INTO tbl_reference (Title, Chapter, Subject_ID, Ref_Link) VALUES ('$input_title','$input_chapter','$input_subject','$input_link')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Reference material successfully uploaded !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

if(isset($_POST['txt_marks_submit'])){

  $input_txt_marks = $_POST['txt_marks'];
  $input_text_assignment_id = $_POST['text_assignment_id'];
  $input_text_student_id = $_POST['text_student_id'];

  ?><script><?php echo "Error: " . $input_txt_marks . "<br>" ?></script><?php
  ?><script><?php echo "Error: " . $input_text_assignment_id . "<br>" ?></script><?php

  $sql = " UPDATE tbl_assign_submission SET marks = '$input_txt_marks' WHERE (Assignment_ID = '$input_text_assignment_id' and Student_ID = '$input_text_student_id' )";
  $result = $conn->query($sql);
  if ($result) {
    ?><script>alert("Marks successfully uploaded !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teacher</title>
  <!-- CSS links -->
  <link rel="stylesheet" href="mycss/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <!-- JS links -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="teacher.php"><i class="fa fa-users"></i><span class="sr-only">(current)</span></a>
        </li>
        <li><a class="navbar-brand" href="teacher.php">Classmate</a></li>
      </ul>
      <span class="navbar-text">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Calendar</button>
      </span>
    </div>
  </nav>

  <!-- Calendar -->
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Events</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php
            $today = date("Y-m-d");
            $sql = "SELECT Title,Description,Event_Date FROM tbl_event where Event_Date >'".$today."' order by Event_Date;";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
              $event_date = $row['Event_Date'];
              $e_Date = date_create($event_date);
          ?>
          <div class="calendar">
            <div class="row event-box">
              <div class="col-2 date_column">
                <span style="font-size: 20px;"><?php echo date_format($e_Date,"d");  ?></span><br>
                <span style="font-size: 10px;"><?php echo date_format($e_Date,"M Y");  ?></span>
              </div>
              <div class="col-10 info_column">
                <h5 style="margin-top:5px;"><?php echo $row['Title']; ?></h5>
                <i><?php echo $row['Description']; ?></i>
              </div>
            </div>
          </div>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container-fluid" style="margin-top:80px;">
    <div class="row">
      <div class="col"><h5>Hi <?php echo $_SESSION['teacherName']; ?></h5></div>
      <div class="col text-right"><h5><a href="logoutTeacher.php"style="text-decoration: none; color: black">Logout</a></h5></div>
    </div>
    <br>
    <!-- Tabs -->
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-upload-reference-tab" data-toggle="tab" href="#nav-view-assignment" role="tab" aria-controls="nav-view-assignment" aria-selected="false">View Assignment</a>
        <a class="nav-item nav-link" id="nav-upload-notes-tab" data-toggle="tab" href="#nav-upload-notes" role="tab" aria-controls="nav-upload-notes" aria-selected="true">Upload Notes</a>
        <a class="nav-item nav-link" id="nav-upload-assignment-tab" data-toggle="tab" href="#nav-upload-assignment" role="tab" aria-controls="nav-upload-assignment" aria-selected="false">Upload Assignment</a>
        <a class="nav-item nav-link" id="nav-upload-qb-tab" data-toggle="tab" href="#nav-upload-qb" role="tab" aria-controls="nav-upload-qb" aria-selected="false">Upload Question Bank</a>
        <a class="nav-item nav-link" id="nav-upload-reference-tab" data-toggle="tab" href="#nav-upload-reference" role="tab" aria-controls="nav-upload-reference" aria-selected="false">Upload Reference</a>
      </div>
    </nav>
    <!-- Display Tab Content -->
    <div class="tab-content" id="nav-tabContent">
    <!-- Display View Assignment -->
      <div class="tab-pane fade show active" id="nav-view-assignment" role="tabpanel" aria-labelledby="nav-view-assignment-tab">
          <?php
            if(isset($_POST['btn-view-assignment'])){
              $input_subject = $_POST['txt_subject'];
              $input_assignment = $_POST['txt_assignment'];
              ?>
        <div class="container" style="margin-top:25px;padding:30px 100px;">
            <?php
              $sql1 = "SELECT * FROM tbl_subject where Subject_ID ='".$input_subject."'";
              $result1 = $conn->query($sql1);
              while($row1 = $result1->fetch_assoc()) {
            ?>
          <h5>
          <a href="teacher.php"><i class="fa fa-arrow-left"></i></a>&nbsp
            <?php
                echo $row1['Name']." - " ;
              }
              $sql2 = "SELECT * FROM tbl_assignment where Assignment_ID ='".$input_assignment."'";
              $result2 = $conn->query($sql2);
              while($row2 = $result2->fetch_assoc()) {
               echo $row2['Title'];
              }
            ?>
          </h5>
          <br>
          <div class="text-right" style="margin-right: 100px;"><button class="btn btn-info" id="download"> Download Excel Sheet </button></div>
          <br>
          <table id="assignment-reports" class="table">
            <tr>
              <th>Student</th>
              <th>Submitted Date</th>
              <th>Status</th>
              <th>View</th>
	            <th>Marks</th>
            </tr>
            <?php
              $sql = "SELECT * FROM tbl_assign_submission where Subject_ID ='".$input_subject."' and Assignment_ID ='".$input_assignment."' order by Student_ID";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
            ?>
            <tr>
              <td><?php echo $row['Student_ID'] ?></td>
              <td><?php echo $row['Submitted_Date']; ?></td>
              <td><?php echo $row['Status']; ?></td>
              <td>
                <form action="viewMe.php" method="post">
                  <input type="hidden" name="txt_path" value="<?php echo $row['Submission_File']; ?>">
                  <button type="submit" style="border:none; background-color: transparent;">
                    <i class="fa fa-eye" style="font-size: 28px"></i>
                  </button>
                </form>
              </td>
              <td>
              <form action="teacher.php" method="post" >
                <div style="display:flex">
                <input type="hidden" name="text_assignment_id" value="<?php echo $row['Assignment_ID']; ?>">
                <input type="hidden" name="text_student_id" value="<?php echo $row['Student_ID']; ?>">
              <input type="text" name="txt_marks" style= "width: 18%" class="form-control"value="<?php echo $row['marks']; ?>">
              <button type="submit" name="txt_marks_submit" style="border:none;  background-color: #e9ecef; border-radius: 10px; margin: auto;">
                    <b>Submit</b>
                  </button>
              </form>
              </div>
             </td>
            </tr>
            <?php
            }
            ?>
          </table>

          <script>
          $('#download').click(function () {
                  $("#assignment-reports").table2excel({
                  filename: "Reports.xls"
              });
          });
          </script>

        </div>
          <?php
          }else{
          ?>
        <div class="container" style="margin-top:25px;padding:30px 300px;">
          <form action="teacher.php" method="post">
            <label>Select Subject:</label>
            <select class="form-control" name="txt_subject" required>
            <?php
              $sql = "SELECT Subject_ID,Name, Class FROM tbl_subject where Teacher_ID ='".$teacherID."'";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row['Subject_ID']; ?>"><?php echo $row['Name']." - Class ".$row['Class'] ; ?></option>
            <?php
              }
            ?>
            </select>
            <br>
            <label>Select Assignment:</label>
            <select class="form-control" name="txt_assignment" required>
            <?php
              $sql = "SELECT * FROM tbl_assignment where Teacher_ID ='".$teacherID."'";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
            ?>
              <option value="<?php echo $row['Assignment_ID']; ?>"><?php echo $row['Title']; ?></option>
            <?php
            }
            ?>
            </select>
            <br>
            <button type="submit" name="btn-view-assignment" class="btn btn-success form-control">View Assignment</button>
          </form>
        </div>
        <?php
          }
        ?>
      </div>

      <!-- Display Upload Notes -->
      <div class="tab-pane fade " id="nav-upload-notes" role="tabpanel" aria-labelledby="nav-upload-notes-tab">
        <div class="container" style="margin-top:25px;padding:30px 300px;">
          <form action="teacher.php" method="post" enctype="multipart/form-data">
            <label>Select Subject:</label>
            <select class="form-control" name="txt_subject" required>
              <?php
              $sql = "SELECT Subject_ID,Name, Class FROM tbl_subject where Teacher_ID ='".$teacherID."'";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $row['Subject_ID']; ?>"><?php echo $row['Name']." - Class ".$row['Class'] ; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <label>Notes Title:</label>
            <input type="text" name="txt_title" class="form-control" required>
            <br>
            <label>Chapter:</label>
            <input type="text" name="txt_chapter" class="form-control" required>
            <br>
            <label>Upload Notes File:</label>
            <input type="file" name="txt_notes_file" class="form-control" required>
            <br>
            <button type="submit" name="btn-upload-notes" class="btn btn-success form-control">Upload Notes</button>
          </form>
        </div>
      </div>

      <!-- Display Upload Assignment -->
      <div class="tab-pane fade" id="nav-upload-assignment" role="tabpanel" aria-labelledby="nav-upload-assignment-tab">
        <div class="container" style="margin-top:25px;padding:30px 300px;">
          <form action="teacher.php" method="post" enctype="multipart/form-data">
            <label>Select Subject:</label>
            <select class="form-control" name="txt_subject" required>
              <?php
              $sql = "SELECT Subject_ID,Name, Class FROM tbl_subject where Teacher_ID ='".$teacherID."'";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $row['Subject_ID']; ?>"><?php echo $row['Name']." - Class ".$row['Class'] ; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <label>Assignment Title:</label>
            <input type="text" name="txt_title" class="form-control" required>
            <br>
            <label>Submission Date:</label>
            <input type="date" name="txt_sdate" class="form-control" required>
            <br>
            <label>Upload Assignment File:</label>
            <input type="file" name="txt_assignment_file" class="form-control" required>
            <br>
            <button type="submit" name="btn-upload-assignment" class="btn btn-success form-control">Upload Assignment</button>
          </form>
        </div>
      </div>

      <!-- Display Upload Question Bank -->
      <div class="tab-pane fade" id="nav-upload-qb" role="tabpanel" aria-labelledby="nav-upload-qb-tab">
        <div class="container" style="margin-top:25px;padding:30px 300px;">
          <form action="teacher.php" method="post" enctype="multipart/form-data">
            <label>Select Subject:</label>
            <select class="form-control" name="txt_subject" required>
              <?php
              $sql = "SELECT Subject_ID,Name, Class FROM tbl_subject where Teacher_ID ='".$teacherID."'";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $row['Subject_ID']; ?>"><?php echo $row['Name']." - Class ".$row['Class'] ; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <label>Question paper Year:</label>
            <input type="text" name="txt_year" class="form-control" required>
            <br>
            <label>Upload Question Paper:</label>
            <input type="file" name="txt_qb_file" class="form-control" required>
            <br>
            <button type="submit" name="btn-upload-qb" class="btn btn-success form-control">Upload Question Bank</button>
          </form>
        </div>
      </div>

      <!-- Display Upload Reference -->
      <div class="tab-pane fade" id="nav-upload-reference" role="tabpanel" aria-labelledby="nav-upload-reference-tab">
        <div class="container" style="margin-top:25px;padding:30px 300px;">
          <form action="teacher.php" method="post">
            <label>Select Subject:</label>
            <select class="form-control" name="txt_subject" required>
              <?php
              $sql = "SELECT Subject_ID,Name, Class FROM tbl_subject where Teacher_ID ='".$teacherID."'";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $row['Subject_ID']; ?>"><?php echo $row['Name']." - Class ".$row['Class'] ; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <label>Reference Title:</label>
            <input type="text" name="txt_title" class="form-control" required>
            <br>
            <label>Chapter:</label>
            <input type="text" name="txt_chapter" class="form-control" required>
            <br>
            <label>Reference Link:</label>
            <input type="text" name="txt_link" class="form-control" required>
            <br>
            <button type="submit" name="btn-upload-reference" class="btn btn-success form-control">Upload Reference Link</button>
          </form>
        </div>
      </div>

    </div>
  </div>

</body>
</html>

<?php
$conn->close();
?>
