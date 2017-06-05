<?php
require_once 'Bootstrap.php';
Session::getInstance();
include './inc/singletone.php';
$singletone = UserFactory::Instance();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <script
  src="http://code.jquery.com/jquery-3.1.1.js"
  integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
  crossorigin="anonymous"></script>
    <title>Mon super projet</title>

    <!-- Bootstrap core CSS -->
    <link href="css/app.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Mon super projet</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <?php if(isset($_SESSION['auth'])): ?>
            <li><a href="account.php">profil</a></li>
            <li><a href="logout.php">Se deconecter</a></li>
          <?php else: ?>
            <li><a href="register.php">S'inscrire</a></li>
            <li><a href="login.php">Se connecter</a></li>
          <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
    <?php if(Session::getInstance()->hasFlash()): ?>
      <?php foreach(Session::getInstance()->getFlash() as $type => $message): ?>
        <div class="alert alert-<?= $type; ?>">
          <?= $message; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>
