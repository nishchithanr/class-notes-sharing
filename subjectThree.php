<?php
session_start();
$myid = $_SESSION['sid'];
$myclass = $_SESSION['class'];
$myclass = "STD".$myclass."3";
$conn = new mysqli('localhost', 'root', '', 'classmate');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if(isset($_POST['btn-upload-my-assignment'])){
  $input_ass_id = (int) $_POST['txt_ass_id'];
  $input_submitted = $_POST['txt_submission'];
  $sub_date = date_create($input_submitted);
  $submission = date_format($sub_date,"Y-m-d");
  $today = date("Y-m-d");
  if($submission >= $today){
    $status = "On-time";
  }else{
    $status = "Delay";
  }

  $file_name = rand(1000,10000)."-".$_FILES['txt_file']['name'];

  $temp_name = $_FILES['txt_file']['tmp_name'];
  $upload_dir = "Notes_Files/";
  move_uploaded_file($temp_name,$upload_dir . $file_name);

  $sql = "INSERT INTO tbl_assign_submission (Assignment_ID, Student_ID, Submitted_Date, Status,Subject_ID, Submission_File) VALUES ('$input_ass_id','$myid','$today','$status','$myclass','$file_name')";
  $result = $conn->query($sql);
  if ($result) {?>
    <script>alert("Assignment successfully uploaded !!!");</script><?php
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
  <title>Student</title>
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
          <a class="nav-link" href="student.php"><i class="fa fa-users"></i><span class="sr-only">(current)</span></a>
        </li>
        <li>
          <a class="navbar-brand" href="student.php">Classmate</a>
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
          $sql = "SELECT Title,Description,Event_Date FROM tbl_event where Event_Date >='".$today."' order by Event_Date;";
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



  <div class="sidebar">
    <ul>
      <li><a style="text-decoration: none; color: black">Hi <?php echo $_SESSION['name']; ?></a></li>
      <li>Subject</li>
      <ul>
        <li><a href="subjectOne.php" class="sidebar-menu">English</a></li>
        <li><a href="subjectTwo.php" class="sidebar-menu">Kannada</a></li>
        <li><a href="subjectThree.php" class="sidebar-menu">Hindi</a></li>
        <li><a href="subjectFour.php" class="sidebar-menu">Mathematics</a></li>
        <li><a href="subjectFive.php" class="sidebar-menu">Science</a></li>
        <li><a href="subjectSix.php" class="sidebar-menu">Social Science</a></li>
      </ul>
      <li><a href="logout.php" style="text-decoration: none; color: black">Logout</a></li>
    </ul>
  </div>

  <div class="content">
    <h4 class="text-right">Subject - Hindi</h4>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="true">Notes</a>
        <a class="nav-item nav-link" id="nav-assignment-tab" data-toggle="tab" href="#nav-assignment" role="tab" aria-controls="nav-assignment" aria-selected="false">Assignment</a>
        <a class="nav-item nav-link" id="nav-qb-tab" data-toggle="tab" href="#nav-qb" role="tab" aria-controls="nav-qb" aria-selected="false">Question Bank</a>
        <a class="nav-item nav-link" id="nav-reference-tab" data-toggle="tab" href="#nav-reference" role="tab" aria-controls="nav-reference" aria-selected="false">Reference</a>
      </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">

      <div class="tab-pane fade show active" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
        <?php
          $sql = "SELECT * FROM tbl_notes where Subject_ID = '".$myclass."' order by Chapter;";
          $result = $conn->query($sql);

          while($row = $result->fetch_assoc()) {
            ?>
        <div class="container custom-list">
          <div class="row">
            <div class="col-10"><?php echo $row['Title']; ?></div>
            <div class="col-1">
              <form action="viewMe.php" method="post">
                <input type="hidden" name="txt_path" value="<?php echo $row['Notes_File']; ?>">
                <button type="submit" style="border:none; background-color: transparent;">
                  <i class="fa fa-eye" style="font-size: 28px"></i>
                </button>
              </form>
            </div>
            <div class="col-1">
              <form action="downloadMe.php" method="post">
                <input type="hidden" name="txt_path" value="<?php echo $row['Notes_File']; ?>">
                <button type="submit" style="border:none; background-color: transparent;">
                  <i class="fa fa-download" style="font-size: 28px"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php
          }
        ?>
      </div>

      <div class="tab-pane fade" id="nav-assignment" role="tabpanel" aria-labelledby="nav-assignment-tab">
        <?php
          $today = date("Y-m-d");
          $sql = "SELECT * FROM tbl_assignment where Subject_ID = '".$myclass."' and Submission >= '".$today."' order by Submission;";
          $result = $conn->query($sql);

          while($row = $result->fetch_assoc()) {

            $assign_id = $row['Assignment_ID'];
            $sub_date = $row['Submission'];
            $formatteddate = date_create($sub_date);


        ?>
        <div class="container custom-list">
          <div class="row">
            <div class="col-8"><h6><?php echo $row['Title']; ?></h6><i style="font-size:12px; color:grey;">Submission by: <?php echo date_format($formatteddate,"d M Y"); ?></i></div>
            <div class="col-1">
              <form action="viewMe.php" method="post">
                <input type="hidden" name="txt_path" value="<?php echo $row['Assignment_File']; ?>">
                <button type="submit" style="border:none; background-color: transparent;">
                  <i class="fa fa-eye" style="font-size: 28px"></i>
                </button>
              </form>
            </div>

            <?php
            $sql_AS = "select * from tbl_assign_submission where Assignment_ID = '".$assign_id."' and Student_ID = '".$myid."'";
            $result_AS = mysqli_query($conn, $sql_AS);
            $row_AS = mysqli_fetch_array($result_AS);

            if(is_array($row_AS)){
              ?>
              <div class="col-1">
                <form action="viewMe.php" method="post">
                  <input type="hidden" name="txt_path" value="<?php echo $row_AS['Submission_File']; ?>">
                  <button type="submit" style="border:none; background-color: transparent;">
                    <i class="fa fa-file"  style="font-size: 28px"></i><br>Preview
                  </button>
                </form>
              </div>
              <?php
            }else{
              ?>
              <div class="col-1">
                  <button type="button"  data-toggle="modal" data-target="#exampleModal" style="border:none; background-color: transparent;">
                    <i class="fa fa-upload" style="font-size: 28px"></i>
                  </button>

                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="subjectThree.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="txt_ass_id" value="<?php echo $row['Assignment_ID']; ?>">
                            <input type="hidden" name="txt_submission" value="<?php echo $row['Submission']; ?>">
                            <input type="text" class="form-control" readonly name="txt_a_name" value="<?php echo $row['Title']; ?>">
                            <br>
                            <label>Upload Assignment:</label>
                            <input type="file" name="txt_file" class="form-control" required>
                            <br>
                            <button type="submit" class="btn btn-success form-control" name="btn-upload-my-assignment">Upload My Assignment</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>


              </div>
              <?php
            }
           
            if((is_array($row_AS))&&($row_AS['marks'])){
              ?>
             <div class="col-2">
                <label> <b><?php echo "Marks : " . $row_AS["marks"]; echo " / 20" ?></b> </label> 
            </div>
            <?php
          }
          ?>
          </div>
        </div>
        <?php
          }
        ?>
      </div>







      <div class="tab-pane fade" id="nav-qb" role="tabpanel" aria-labelledby="nav-qb-tab">
      <?php
        $sql = "SELECT * FROM tbl_qb where Subject_ID = '".$myclass."' order by Year DESC;";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
      ?>
        <div class="container custom-list">
          <div class="row">
            <div class="col-10"><?php echo $row['Year']; ?></div>
            <div class="col-1">
              <form action="viewMe.php" method="post">
                <input type="hidden" name="txt_path" value="<?php echo $row['Qb_File']; ?>">
                <button type="submit" style="border:none; background-color: transparent;">
                  <i class="fa fa-eye" style="font-size: 28px"></i>
                </button>
              </form>
            </div>
            <div class="col-1">
              <form action="downloadMe.php" method="post">
                <input type="hidden" name="txt_path" value="<?php echo $row['Qb_File']; ?>">
                <button type="submit" style="border:none; background-color: transparent;">
                  <i class="fa fa-download" style="font-size: 28px"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php
          }
        ?>
      </div>

      <div class="tab-pane fade" id="nav-reference" role="tabpanel" aria-labelledby="nav-reference-tab">
      <?php
        $sql = "SELECT * FROM tbl_reference where Subject_ID = '".$myclass."' order by Chapter;";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
      ?>
        <div class="container custom-list">
          <div class="row">
            <div class="col-10"><?php echo $row['Title']; ?></div>
            <div class="col-2">
              <a href="<?php echo $row['Ref_Link']; ?>"> <i class="fa fa-globe" style="font-size: 28px"></i></a>
            </div>
          </div>
        </div>
      <?php
        }
      ?>
      </div>


    </div>
  </div>

</body>

</html>
<?php
$conn->close();
?>
