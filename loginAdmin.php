<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'classmate');
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['btn-login'])){

  $input_user = $_POST['txt_user'];
  $input_pass = $_POST['txt_pass'];

  $sql = "select * from tbl_admin where UserName = '$input_user' and Password = '$input_pass'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);


echo $row ;

  if(is_array($row)){
    $_SESSION['name'] = $row['UserName'];
    $_SESSION['class'] = $row['Password'];

    ?>
    <script>
      alert("<?php echo "Welcome ".$row['Name']; ?>");
    </script>
    <?php

  }else{
    ?>
    <script>
  alert($result);
      window.location.href="loginAdmin.php";
      alert("Unsuccessful Login Attempt !!!");
    </script>
    <?php
  }
}
if(isset($_SESSION['name'])){
  ?>
  <script>
    window.location.href="admin.php";
  </script>
  <?php
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
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
<style>
body {
  background-image: url('ADMIN.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
}
.container {
    display: inline-block;
    position: fixed;
    top: 0;
    box-sizing: border-box;
    padding: 10px;
    bottom: 0;
    left: 0;
    right: 0;
    width: 450px;
    height: 350px;
    margin: auto;
    background-color: #f3f3f3;
}
</style>
<div class="container";>
<form action="loginAdmin.php" method="post">
  <h4 class="text-center">LOGIN</h4>
  <br><br>
  <label>Admin:</label>
  <input type="text" class="form-control" placeholder="Enter the Name" name="txt_user" required>
  <br>
  <label>Password:</label>
  <input type="password" class="form-control" placeholder="Password" name="txt_pass" required>
  <br>
  <button type="submit" name="btn-login" class="btn btn-success form-control" name="button">LOGIN</button>
</form>
</div>


</body>
</html>
<?php
$conn->close();
 ?>
