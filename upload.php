<?php
// Target directory for images
$target_dir = "public/upload/";

$target_file = $target_dir . time() . "." . pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_FILES["image"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["image"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        require_once "Repositories/CR_File.php";
        require_once "CodeRead.php";
        $image    = new CR_File($target_file);
        $codeRead = new CodeRead($image, 1);
        $result   = $codeRead->execute();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>CodeRead</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="public/assets/css/bootstrap-theme.min.css" rel="stylesheet">
  <style type="text/css">
    .starter-template {
      padding: 40px 15px;
      text-align: center;
    }
    body {
      padding-top: 70px;
      padding-bottom: 30px;
    }

    .theme-dropdown .dropdown-menu {
      display: block;
    }

    .theme-showcase > p > .btn {
      margin: 5px 0;
    }

  .theme-showcase .navbar .container {
    width: auto;
  }
  </style>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Code Read</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="credits.html">Credits</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" style="width:960px;">

      <div class="starter-template">
        <h1>Code Read</h1>
        <p class="lead">Compile snapshots of Code!</p>
      </div>
    
      <form class="col-lg-4 col-lg-offset-3" method="post" action="runCode.php">
      <div class="row">
        <div class="form-group">
        <label>Code:</label>
          <textarea id="code" name="code" cols="60" rows="8">
              <?php
              print_r($result->code);
              ?>
          </textarea>
        </div>
      </div>
      <div class="row form-group">
        <button type="submit" name="compile" id="compile" class="btn-lg btn-success">Re-Compile!</button>
      </div>
    </form>
    <br>
    <br>
    <br>
    <div class="col-lg-4 col-lg-offset-3"> 
    <h3>Output</h3>
        <?php
            print_r($result->output[0]);
        ?>
    </div>
    </div>
</body>
  <script src="public/assets/js/bootstrap.min.js"></script>
</html>