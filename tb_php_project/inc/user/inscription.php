<?php
session_start();
require("user_func.php");
if($_POST) {
    $username = "";
    $password = "";
    $password_confirmed = "";
    $code_pin = "";
    //$errors_array = array();
    $errors_array = [];

    if(captchaFieldIsValid($_POST['captcha_challenge_inscription'],$_SESSION['captcha_text'])){

        //username
        if(usernameFieldIsValid($_POST['username_inscription'])){
            if(userExists($_POST['username_inscription']) == false){
                $username = $_POST['username_inscription'];
            }
            else{
                $errors_array["userExistsError"] = "Nom d'utilisateur existe déjà !";
            }
        }
        else{
            $errors_array["usernameFormatError"] = "Format nom d'utilisateur invalide !";
        }

        //password
        if (passwordFieldIsValid($_POST['password_inscription']) && samePassword($_POST['password_inscription'],$_POST['password_confirmed_inscription'])){
            $password =$_POST['password_inscription'];
        }
        else{
            $errors_array["passwordError"] = "Mots de passe non identique !";
        }

        //codepin
        if(pincodeFieldIsValid($_POST['pincode_inscription'])){
            $code_pin = $_POST['pincode_inscription'];
        }
        else{
            $errors_array["codepinError"] = "Format code PIN invalide !";

        }
        if(empty($errors_array)){
            $isUserSaved = saveUser($username,$password,$code_pin);
            if($isUserSaved){
                $_SESSION['userSaved'] = "Utilisateur enregistré ! ";
                header("Location: ../../index.php");
            }
            else{
                $errors_array["userinsertError"] = "Impossible de sauvegarder !";
                $_SESSION['inscriptionErrors'] = $errors_array;
                header("Location: ../../tpl/inscription/inscription.php");
            }
        }
        else{
            $_SESSION['inscriptionErrors'] = $errors_array;
            header("Location: ../../tpl/inscription/inscription.php");
        }
    }
    else{
        $errors_array["captchaError"] = "Captcha invalide !";
        $_SESSION['inscriptionErrors'] = $errors_array;
        header("Location: ../../tpl/inscription/inscription.php");
    }

} else {
    $errors_array["requestError"] = "Erreur de requête !";
    $_SESSION['inscriptionErrors'] = $errors_array;
    header("Location: ../../tpl/inscription/inscription.php");
}

?>

