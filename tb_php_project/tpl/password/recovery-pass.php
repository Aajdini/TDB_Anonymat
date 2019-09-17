<?php
session_start();
if(!isset($_SESSION['recoveryUserPassword'])) {
    header('location:../../index.php');
}
else{
    $name_session_usr_recovery = $_SESSION['recoveryUserPassword'];
}
$requestError= "";
$passwordErrorRecoveryPass = "";
if(isset($_SESSION['recoveryPassErrors'])){
    foreach($_SESSION['recoveryPassErrors'] as $key => $value) {
        switch ($key) {
            case "passwordErrorRecoveryPass":
                $passwordErrorRecoveryPass = $value;
                break;
            case "requestError":
                $requestError = $value;
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
    <link rel="stylesheet" type="text/css" href="../../tpl/css/recovery-pass.css">
    <title>Bienvenue</title>
</head>
<body>
<?php
require("../../tpl/navbar-footer/navbar_public.php");
?>
<div class="container h-100">
    <h1 class="display-4 text-center" id ="title">Changer le mot de passe</h1>
    <div class="d-flex justify-content-center align-self-center h-100" id="principal_section">
        <div class="card" id="card_inscription">
            <div class="card-header">
                <h4 class="display-5 text-center">Formulaire création nouveau mot de passe</h4>
            </div>
            <div class="card-body">
                <form action="../../inc/user/recovery-pass.php" method="post">

                    <?php if(!empty($_SESSION['recoveryPassErrors'])){?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Erreur !</strong>
                            <?php echo $requestError;?>
                            <?php echo $passwordErrorRecoveryPass;?>
                            <?php unset($_SESSION['recoveryPassErrors']);?>
                        </div>
                    <?php } ?>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i> *</span>
                        </div>
                        <input type="password" class="form-control" minlength="8" maxlength="15" name="password_recovery-pass" placeholder="Mot de passe">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="15 chars MAX, 8 chars MIN">
                            <i class="fas fa-info"></i>
                        </button
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i> *</span>
                        </div>
                        <input type="password" class="form-control" minlength="8" maxlength="15" name="password_confirmed_recovery-pass" placeholder="Confirmer mot de passe">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right" title="15 chars MAX, 8 chars MIN">
                            <i class="fas fa-info"></i>
                        </button
                    </div>

                    <div class="input-group form-group">
                        <input class="btn btn-dark btn-block" type="submit" name="submit_recovery-pass" value="Créer nouveau mot de passe">
                    </div>
                </form>
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