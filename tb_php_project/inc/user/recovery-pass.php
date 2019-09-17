<?php
session_start();
require("user_func.php");
if($_POST) {
    $password = "";
    $password_confirmed = "";
    $errors_array = [];

    //password
    if (passwordFieldIsValid($_POST['password_recovery-pass']) && samePassword($_POST['password_recovery-pass'],$_POST['password_confirmed_recovery-pass'])){
        $password = $_POST['password_recovery-pass'];
    }
    else{
        $errors_array["passwordErrorRecoveryPass"] = "Champ(s) manquant(s) ou mots de passe non identiques !";
    }

    if(empty($errors_array)){
        //query update mdp sha1
        $bool = resetPassword($_SESSION['recoveryUserPassword'],$password);
        unset($_SESSION['recoveryUserPassword']);
        $_SESSION['passwordSaved'] = "Mot de passe modifié ! ";
        header("Location:../../index.php");
    }
    else{
        $_SESSION['recoveryPassErrors'] = $errors_array;
        header("Location: ../../tpl/password/recovery-pass.php");
    }

} else {
    $errors_array["requestError"] = "Erreur de requête !";
    $_SESSION['recoveryMainErrors'] = $errors_array;
    header("Location: ../../tpl/password/recovery-main.php");
}

?>