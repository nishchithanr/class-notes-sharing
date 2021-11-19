<?php
session_start();
if(session_destroy()){
  ?>
  <script>
  window.location.href="loginAdmin.php";
  </script>
  <?php
}

?>
