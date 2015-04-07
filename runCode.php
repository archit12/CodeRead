<?php
if (isset($_POST['code'])) {
  require_once "Repositories/CR_File.php";
  require_once "Compiler/CCompiler.php";
  $codeFilePath = "public/output/reviewCode.c";
  $file         = new CR_File($codeFilePath);
  $file->write($_POST['code']);
  $compiler     = new CCompiler($file);
  $output       = $compiler->compile();
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
        <label>Output:</label>
          <textarea id="code" name="code" cols="60" rows="8">
              <?php
                echo $output[0];
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
    </div>
</body>
  <script src="public/assets/js/bootstrap.min.js"></script>
</html>