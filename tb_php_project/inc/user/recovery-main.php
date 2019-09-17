<?php
session_start();
require("user_func.php");
if($_POST) {
    $username = "";
    $code_pin = "";
    $errors_array = [];

    if(captchaFieldIsValid($_POST['captcha_challenge_recovery-main'],$_SESSION['captcha_text'])){
        //username
        if(usernameFieldIsValid($_POST['username_recovery-main'])){
            $username = $_POST['username_recovery-main'];
        }
        else{
            $errors_array["usernameFormatError"] = "Format nom d'utilisateur invalide !";
        }
        //codepin
        if(pincodeFieldIsValid($_POST['pincode_recovery-main'])){
            if(checkPinCode($username,$_POST['pincode_recovery-main'])){
                $code_pin = $_POST['pincode_recovery-main'];
            }
            else{
                $errors_array["codepinInvalidError"] = "Nom d'utilisateur ou code PIN invalide !";
            }
        }
        else{
            $errors_array["codepinError"] = "Format code PIN invalide !";

        }
        if(empty($errors_array)){
                $_SESSION['recoveryUserPassword'] = $username;
                header("Location:../../tpl/password/recovery-pass.php");
        }
        else{
            $_SESSION['recoveryMainErrors'] = $errors_array;
            header("Location: ../../tpl/password/recovery-main.php");
        }
    }
    else{
        $errors_array["captchaError"] = "Captcha invalide !";
        $_SESSION['recoveryMainErrors'] = $errors_array;
        header("Location: ../../tpl/password/recovery-main.php");
    }

} else {
    $errors_array["requestError"] = "Erreur de requête !";
    $_SESSION['recoveryMainErrors'] = $errors_array;
    header("Location: ../../tpl/password/recovery-main.php");
}

?>

