<?php
session_start();
if(session_destroy()){
  ?>
  <script>
  window.location.href="login.php";
  </script>
  <?php
}

?>
