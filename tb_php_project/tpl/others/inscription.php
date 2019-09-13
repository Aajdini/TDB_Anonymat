<?php  ?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="../../tpl/js/fontawesome.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../tpl/css/bootstrap/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="../../tpl/css/inscription.css">
    <title>Bienvenue</title>
</head>
<body>
<?php
require("../../tpl/navbar-footer/navbar_public.php");
?>
<div class="container h-100">
    <h1 class="display-4 text-center" id ="title">Inscription</h1>
    <div class="d-flex justify-content-center align-self-center h-100" id="principal_section">
        <div class="card" id="card_inscription">
            <div class="card-header">
                <h4 class="display-5 text-center">Formulaire d'inscription</h4>
            </div>
            <div class="card-body">
                <form action="../../inc/db/inscription.php" method="post">

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="username_inscription" maxlength="12" minlength="5" placeholder="Nom d'utilisateur">
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" minlength="8" maxlength="15" name="password_inscription" placeholder="Mot de passe">
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" minlength="8" maxlength="15" name="password_confirmed_inscription" placeholder="Confirmer mot de passe">
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                        </div>
                        <input type="number"  class="form-control" name="pincode_inscription" placeholder="Code PIN">
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-robot"></i></span>
                        </div>
                        <input type="text" id="captcha" name="captcha_challenge_inscription" class="form-control" pattern="[A-Z]{6}" placeholder="Veuillez saisir le text de l'image">
                    </div>

                    <div class="form-group" id="captcha_inscription">
                        <img src="../../inc/sec/captcha.php" alt="CAPTCHA" class="captcha-image">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-info btn-block" type="submit" name="submit_inscription" value="S'inscrire">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    Déjà un compte ?  <a href="../../index.php">  Connexion</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../tpl/js/jquery-3.4.1.slim.min.js" ></script>
<script src="../../tpl/js/propper-1.15.0.min.js" ></script>
<script src="../../tpl/js/bootstrap/bootstrap.min.js"></script>

</body>
</html>