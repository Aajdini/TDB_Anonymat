<?php
session_start();
$requestError= "";
$captchaError = "";
$userExistsError = "";
$usernameFormatError = "";
$passwordError = "";
$codepinError = "";
$userinsertError = "";

if(isset($_SESSION['inscriptionErrors'])){
    foreach($_SESSION['inscriptionErrors'] as $key => $value) {
        switch ($key) {
            case "requestError":
                $requestError = $value;
                break;
            case "captchaError":
                $captchaError = $value;
                break;
            case "userExistsError":
                $userExistsError = $value;
                break;
            case "usernameFormatError":
                $usernameFormatError = $value;
                break;
            case "passwordError":
                $passwordError = $value;
                break;
            case "codepinError":
                $codepinError = $value;
                break;
            case "userinsertError":
                $userinsertError = $value;
                break;
        }
    }
}
?>
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
                <form action="../../inc/user/inscription.php" method="post">
                    <?php if(!empty($_SESSION['inscriptionErrors'])){?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur !</strong>
                            <?php echo $requestError;?>
                            <?php echo $captchaError;?>
                            <?php echo $userExistsError;?>
                            <?php echo $usernameFormatError;?>
                            <?php echo $passwordError;?>
                            <?php echo $codepinError;?>
                            <?php echo $userinsertError;?>
                            <?php unset($_SESSION['inscriptionErrors']);?>
                        </div>
                    <?php } ?>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i> *</span>
                        </div>
                        <input type="text" class="form-control" name="username_inscription" maxlength="12" minlength="5" placeholder="Nom d'utilisateur">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="12 chars MAX, 5 chars MIN, A-Z a-z 0-9 seulement">
                            <i class="fas fa-info"></i>
                        </button
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i> *</span>
                        </div>
                        <input type="password" class="form-control" minlength="8" maxlength="15" name="password_inscription" placeholder="Mot de passe">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="15 chars MAX, 8 chars MIN">
                            <i class="fas fa-info"></i>
                        </button
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i> *</span>
                        </div>
                        <input type="password" class="form-control" minlength="8" maxlength="15" name="password_confirmed_inscription" placeholder="Confirmer mot de passe">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="15 chars MAX, 8 chars MIN">
                            <i class="fas fa-info"></i>
                        </button
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-barcode"></i> *</span>
                        </div>
                        <input type="number"  class="form-control" name="pincode_inscription" placeholder="Code PIN">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="5 nombre MAX - MIN">
                            <i class="fas fa-info"></i>
                        </button
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
                        <img src="../../inc/sec/captcha.php" alt="CAPTCHA" class="captcha-image rounded mx-auto d-block">
                    </div>

                    <div class="input-group form-group">
                        <input class="btn btn-dark btn-block" type="submit" name="submit_inscription" value="S'inscrire">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="p-3 mb-2 bg-secondary text-white">
                    Déjà un compte ?  <a href="../../index.php">  Connexion</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../tpl/js/jquery-3.4.1.slim.min.js" ></script>
<script src="../../tpl/js/propper-1.15.0.min.js" ></script>
<script src="../../tpl/js/bootstrap/bootstrap.min.js"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</body>
</html>