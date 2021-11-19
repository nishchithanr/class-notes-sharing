<?php
session_start();
if(session_destroy()){
  ?>
  <script>
  window.location.href="loginTeacher.php";
  </script>
  <?php
}

?>
