<?php

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="tpl/js/fontawesome.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="tpl/css/bootstrap/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="tpl/css/index.css">
    <title>Bienvenue!</title>
  </head>
  <body>
  <?php
    require("tpl/navbar-footer/navbar_public.php");
  ?>

  <div class="container h-100">

      <h1 class="display-4 text-center" id ="title">Bienvenue</h1>
      <h6 class="text-center" id="site_description">
          Ce service anonyme vous permet d’éditer et d’organiser
          collaborativement des idées, des plans et autres sous forme de note. Ce service
          permet d’éviter la collecte de données personnelles comme c’est le cas avec les
          géants de web du type <mark>GAFAM</mark>, il propose aux utilisateurs un service libre
          respectueux de la vie privée/professionnelle.
      </h6>

      <div class="d-flex justify-content-center align-self-center h-100" id="principal_section">
          <div class="card">
              <div class="card-header">
                  <h4 class="display-5 text-center">Connexion</h4>
              </div>
              <div class="card-body">
                  <form action="inc/db/identification.php" method="post">
                      <div class="input-group form-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                          </div>
                          <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur">
                      </div>
                      <div class="input-group form-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-key"></i></span>
                          </div>
                          <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                      </div>
                      <div class="form-group">
                          <input class="btn btn-info btn-block" type="submit" name="login" value="Log in">
                      </div>
                  </form>
              </div>
              <div class="card-footer">
                  <div class="d-flex justify-content-center links">
                      Pas encore de compte?<a href="#"> Inscription</a>
                  </div>
              </div>
          </div>
      </div>
  </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="tpl/js/jquery-3.4.1.slim.min.js" ></script>
    <script src="tpl/js/propper-1.15.0.min.js" ></script>
    <script src="tpl/js/bootstrap/bootstrap.min.js"></script>

  </body>
</html>