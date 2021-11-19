<?php
  $file = "C:/xampp/htdocs/classmate_new/Notes_Files/". $_POST['txt_path'];
  // echo '<pre>'; print_r($file); echo '</pre>';
  header("Content-Type: application/pdf");
  readfile($file);
?>
