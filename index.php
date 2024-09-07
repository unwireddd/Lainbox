<html>
<head>
    <title>Lainhost</title>
<body>
  <style>
    * {
      text-align: center;
      align-items: center;
    }
    </style>
<?php

    function uploadFile() {
    global $owtput;

    //session_start();

    //session_unset();
    //session_destroy();
    $file = $_FILES['file'];
    $tmp_name = $file['tmp_name'];
     if ($file['type'] == '') {
        $owtput = 'ERROR: no file uploaded!';
        return;
     }
    if ($file['type'] == 'image/png' || $file['type'] == 'image/jpg' || $file['type'] == 'image/jpeg') {
        $result = 'gut';
      } else {
        $owtput = 'ERROR: the only supported file formats are png and jpg!';
        return;
      }

    if ($file['type'] == 'image/png') {
        $ext = '.png';
      } elseif ($file['type'] == 'image/jpeg') {
        $ext = '.jpeg';
      } else {
        $ext = '.jpg';
      }

      echo $file['size'];
      if ($file['size'] > 15000000 ) {
        echo 'ERROR: Max file size is 15 megabytes!';
        return;
      }
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $string = substr(str_shuffle($characters), 0, 10);
    $name = $string . $ext;
    $upload_dir = 'u/';
    $upload_file = $upload_dir . $name;
    move_uploaded_file($tmp_name, $upload_file);
    
    $owtput = "Your uploaded file with type of " . $file['type'] . " should be available at https://localhost:8000/u/" . $name;
    $filenames++;
    header('Location: uploaded.php?message=' . urlencode($owtput));
    exit;

    }

    if(array_key_exists('test',$_POST)){
        uploadFile();
     }
?>
<h1>Lainhost</h1>
<p>The simplest PHP file-hosting service ever made</p>
<form method="post" enctype="multipart/form-data">
Upload your file here: <br>
<input type="file" name="file">
<br>
<br>
<input type="submit" value="Submit" name="test" id="test" value="RUN">
</form>
<?php
if (isset($_FILES['file'])) {
    
} else {
    echo 'No file uploaded';
}
echo $owtput;
?>
<br>
<a href="https://github.com/unwireddd/lainbox">[Open Source]</a>
</body>
</html>