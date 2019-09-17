<?php
session_start();
if(!isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != "") {
    header('location:../../index.php');
}
else{
    $name_session_usr = $_SESSION['sess_user_name'];
    $name_session_id = $_SESSION['sess_user_id'];;
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="../js/fontawesome.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Espace privée</title>
  </head>
  <body>
  <?php
    require("../navbar-footer/navbar.php");
  ?>

  <div class="container h-100">


  </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="../js/jquery-3.4.1.slim.min.js" ></script>
    <script src="../js/propper-1.15.0.min.js" ></script>
    <script src="../js/bootstrap/bootstrap.min.js"></script>

  </body>
</html>

<?php



?>