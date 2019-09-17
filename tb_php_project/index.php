<?php
session_start();
unset($_SESSION['recoveryUserPassword']);
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
      <?php if(isset($_SESSION['userSaved'])){?>
      <div class="alert alert-success" role="alert">
          <strong>Bravo !</strong>
          <?php echo $_SESSION['userSaved'];?> <br>
          <?php unset($_SESSION['userSaved']);?> <br>
      </div>
      <?php } ?>
      <?php if(isset($_SESSION['passwordSaved'])){?>
          <div class="alert alert-success" role="alert">
              <strong>Bravo !</strong>
              <?php echo $_SESSION['passwordSaved'];?> <br>
              <?php unset($_SESSION['passwordSaved']);?> <br>
          </div>
      <?php } ?>
      <div class="d-flex justify-content-center align-self-center h-100" id="principal_section">
          <div class="card" id="card_connexion">
              <div class="card-header">
                  <h4 class="display-5 text-center">Connexion</h4>
              </div>
              <div class="card-body">
                  <form action="inc/user/identification.php" method="post">
                      <?php if(isset($_SESSION['identification_erreur'])){?>
                          <div class="alert alert-danger" role="alert">
                              <strong>Erreur !</strong>
                              <?php echo $_SESSION['identification_erreur'];?> <br>
                              <?php unset($_SESSION['identification_erreur']);?> <br>
                          </div>
                      <?php } ?>
                      <?php if(isset($_SESSION['identification_erreur_champs'])){?>
                          <div class="alert alert-danger" role="alert">
                              <strong>Erreur !</strong>
                              <?php echo $_SESSION['identification_erreur_champs'];?> <br>
                              <?php unset($_SESSION['identification_erreur_champs']);?> <br>
                          </div>
                      <?php } ?>
                      <?php if(isset($_SESSION['identification_erreur_captcha'])){?>
                          <div class="alert alert-danger" role="alert">
                              <strong>Erreur !</strong>
                              <?php echo $_SESSION['identification_erreur_captcha'];?> <br>
                              <?php unset($_SESSION['identification_erreur_captcha']);?> <br>
                          </div>
                      <?php } ?>

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
                      <div class="input-group form-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-robot"></i> *</span>
                          </div>
                          <input type="text" id="captcha" name="captcha_challenge_inscription" class="form-control" pattern="[A-Z]{6}" placeholder="Veuillez saisir le text de l'image">
                          <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="A-Z seulement autorisé">
                              <i class="fas fa-info"></i>
                          </button
                      </div>

                      <div class=" input-group form-group" id="captcha_inscription">
                          <img src="inc/sec/captcha.php" alt="CAPTCHA" class="captcha-image rounded mx-auto d-block">
                      </div>

                      <div class="input-group form-group">
                          <input class="btn btn-dark btn-block" type="submit" name="login" value="Log in">
                      </div>
                  </form>
              </div>
              <div class="card-footer">
                  <div class="card-footer">
                      <div class="p-3 mb-2 bg-secondary text-white ">
                          Pas encore de compte?<a href="tpl/inscription/inscription.php"> Inscription</a>
                      </div>
                      <br>
                      <div class="p-3 mb-2 bg-secondary text-white">
                          Mot de passe oublié ?<a href="tpl/password/recovery-main.php"> Reset mot de passe</a>
                      </div>
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