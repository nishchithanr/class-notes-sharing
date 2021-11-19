<?php
$conn = mysqli_connect('localhost', 'root', '', 'classmate');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['btn-add-event'])){
  $input_title = $_POST['txt_title'];
  $input_desc = $_POST['txt_desc'];
  $input_edate = $_POST['txt_edate'];

  $sql = "INSERT INTO tbl_event (Title, Description, Event_Date) VALUES ('$input_title','$input_desc','$input_edate')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Event successfully added !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

if(isset($_POST['btn-add-student'])){
  $input_regno = $_POST['txt_regno'];
  $input_name = $_POST['txt_name'];
  $input_dob = $_POST['txt_dob'];
  $input_class = $_POST['txt_class'];

  $sql = "INSERT INTO tbl_student (Student_ID, Name, DOB, Class) VALUES ('$input_regno','$input_name','$input_dob','$input_class')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Student successfully added !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

if(isset($_POST['btn-add-teacher'])){
  $input_name = $_POST['txt_name'];
  $input_email = $_POST['txt_email'];
  $input_password = $_POST['txt_password'];

  $sql = "INSERT INTO tbl_teacher (Name, Email, Password) VALUES ('$input_name','$input_email','$input_password')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Teacher successfully added !!!");</script><?php
  } else {
    ?><script><?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}

if(isset($_POST['btn-assign-class'])){
  $input_teacher = (int) $_POST['txt_teacher'];
  $input_subject = $_POST['txt_teach_subject'];
  $input_class = $_POST['txt_teach_class'];

  $sql = "UPDATE tbl_subject SET Teacher_ID = $input_teacher where Name = '$input_subject' and Class = '$input_class'";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Teacher successfully assigned !!!");</script><?php
  } else {
    ?><script>alert(<?php $conn->error; ?>);
    <?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}


if(isset($_POST['btn-remove-teacher'])){
  $input_teacher = (int) $_POST['txt_teacher'];

  $sql = "DELETE FROM tbl_teacher WHERE Teacher_ID = $input_teacher";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Teacher successfully removed!!!");</script><?php
  } else {
    ?><script>alert(<?php $conn->error; ?>);
    <?php echo "Error: " . $sql . "<br>" . $conn->error;?></script><?php
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <!-- CSS links -->
  <link rel="stylesheet" href="mycss/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- JS links -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



</head>

<body>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin.php"><i class="fa fa-users"></i><span class="sr-only">(current)</span></a>
        </li>
        <li>
          <a class="navbar-brand" href="admin.php">Classmate</a>
        </li>
      </ul>

      <span class="navbar-text">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Calendar</button>
      </span>
    </div>
  </nav>




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
              <div class="col-2 date_column"><span style="font-size: 20px;"><?php echo date_format($e_Date,"d");  ?></span><br><span style="font-size: 10px;"><?php echo date_format($e_Date,"M Y");  ?></span></div>
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


  <div class="container-fluid" style="margin-top:80px;">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-add-event-tab" data-toggle="tab" href="#nav-add-event" role="tab" aria-controls="nav-add-event" aria-selected="true">Add Event</a>
        <a class="nav-item nav-link" id="nav-add-student-tab" data-toggle="tab" href="#nav-add-student" role="tab" aria-controls="nav-add-student" aria-selected="false">Add Student</a>
        <a class="nav-item nav-link" id="nav-add-teacher-tab" data-toggle="tab" href="#nav-add-teacher" role="tab" aria-controls="nav-add-teacher" aria-selected="false">Add Teacher</a>
        <a class="nav-item nav-link" id="nav-assign-class-tab" data-toggle="tab" href="#nav-assign-class" role="tab" aria-controls="nav-assign-class" aria-selected="false">Assign Class</a>
        <a class="nav-item nav-link" id="nav-remove-teacher-tab" data-toggle="tab" href="#nav-remove-teacher" role="tab" aria-controls="nav-remove-teacher" aria-selected="false">Remove Teacher</a>
      <a class="nav-item nav-link" href="logoutAdmin.php" style="text-decoration: none; color: black">Logout</a>
      </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">

      <div class="tab-pane fade show active" id="nav-add-event" role="tabpanel" aria-labelledby="nav-add-event-tab">
        <div class="container" style="margin-top:25px;padding:0px 300px;">
          <form action="admin.php" method="post">
            <label>Title:</label>
            <input type="text" name="txt_title" class="form-control" required>
            <br>
            <label>Description:</label>
            <input type="text" name="txt_desc" class="form-control" required>
            <br>
            <label>Event Date:</label>
            <input type="date" name="txt_edate" class="form-control" required>
            <br>
            <button type="submit" name="btn-add-event" class="btn btn-success form-control">Add Event</button>
          </form>
        </div>
      </div>

      <div class="tab-pane fade" id="nav-add-student" role="tabpanel" aria-labelledby="nav-add-student-tab">
        <div class="container" style="margin-top:25px;padding:0px 300px;">
          <form action="admin.php" method="post">
            <label>Roll Number:</label>
            <input type="text" name="txt_regno" class="form-control" required>
            <br>
            <label>Name:</label>
            <input type="text" name="txt_name" class="form-control" required>
            <br>
            <label>DOB:</label>
            <input type="date" name="txt_dob" class="form-control" required>
            <br>
            <label>Class:</label>
            <input type="number" name="txt_class" class="form-control" required>
            <br>
            <button type="submit" name="btn-add-student" class="btn btn-success form-control">Add Student</button>
          </form>
        </div>
      </div>

      <div class="tab-pane fade" id="nav-add-teacher" role="tabpanel" aria-labelledby="nav-add-teacher-tab">
        <div class="container" style="margin-top:25px;padding:0px 300px;">
          <form action="admin.php" method="post">
            <label>Teacher Name:</label>
            <input type="text" name="txt_name" class="form-control" required>
            <br>
            <label>Email:</label>
            <input type="email" name="txt_email" class="form-control" required>
            <br>
            <label>Password:</label>
            <input type="text" name="txt_password" class="form-control" required>
            <br>
            <button type="submit" name="btn-add-teacher" class="btn btn-success form-control">Add Teacher</button>
          </form>
        </div>
      </div>

      <div class="tab-pane fade" id="nav-assign-class" role="tabpanel" aria-labelledby="nav-assign-class-tab">
        <div class="container" style="margin-top:25px;padding:0px 300px;">
          <form action="admin.php" method="post">
            <label>Select Teacher:</label>
            <select class="form-control" name="txt_teacher" required>
              <?php
              $sql = "SELECT * FROM tbl_teacher";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $row['Teacher_ID']; ?>"><?php echo $row['Name'] ; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <label>Select Subject:</label>
            <select class="form-control" name="txt_teach_subject" required>
              <option value="English">English</option>
              <option value="Kannada">Kannada</option>
              <option value="Hindi">Hindi</option>
              <option value="Mathematics">Mathematics</option>
              <option value="Science">Science</option>
              <option value="Social Science">Social Science</option>
            </select>
            <br>
            <label>Select Class:</label>
            <select class="form-control" name="txt_teach_class" required>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="3">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </select>
            <br>
            <button type="submit" name="btn-assign-class" class="btn btn-success form-control">Assign Class</button>
          </form>
        </div>
      </div>

      <div class="tab-pane fade" id="nav-remove-teacher" role="tabpanel" aria-labelledby="nav-remove-teacher-tab">
        <div class="container" style="margin-top:25px;padding:0px 300px;">
          <form action="admin.php" method="post">
            <label>Select Teacher:</label>
            <select class="form-control" name="txt_teacher" required>
              <?php
              $sql = "SELECT * FROM tbl_teacher";
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()) {
              ?>
              <option value="<?php echo $row['Teacher_ID']; ?>"><?php echo $row['Name']; ?></option>
              <?php
              }
              ?>
            </select>
            <br>
            <button type="submit" name="btn-remove-teacher" class="btn btn-success form-control">Remove Teacher</button>
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
