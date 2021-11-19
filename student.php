<?php
session_start();
$myid = $_SESSION['sid'];
$myclass = $_SESSION['class'];
$conn = new mysqli('localhost', 'root', '', 'classmate');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
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
 <div class="content" style="margin:0px 0px 0px 200px;">
   <img src="logo.png" width="400" alt="image not found">
</div>
</body>

</html>
<?php
$conn->close();
?>
