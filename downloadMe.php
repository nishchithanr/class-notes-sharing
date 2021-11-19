<?php

  $file = "C:/xampp/htdocs/classmate/Notes_Files/". $_POST['txt_path'];
  $name = $_POST['txt_path'];
  $file_name = substr($name,5);

  header("Content-Type: application/pdf");
  header("Content-Disposition: attachment; filename=$file_name");
  readfile($file);
?>
