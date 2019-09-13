<?php

session_start();

require ("user_func.php");
if($_POST) {
    $username = "";
    $password = "";
    $password_confirmed = "";
    $code_pin = "";
    $errors_array = [];

    if(captchaFieldIsValid($_POST['captcha_challenge_inscription'],$_SESSION['captcha_text'])){

        //username
        if(usernameFieldIsValid($_POST['username_inscription'])){
            if(!userExists($_POST['username_inscription'])){
                $username = $_POST['username_inscription'];
            }
            else{echo "username exists";}
        }
        else{echo '<p>Username invalid</p>';}

        //password
        if (passwordFieldIsValid($_POST['password_inscription']) && samePassword($_POST['password_inscription'],$_POST['password_confirmed_inscription'])){
            $password =$_POST['password_inscription'];
        }
        else{echo '<p>Mot de passe invalide</p>';}

        //codepin
        if(pincodeFieldIsValid($_POST['pincode_inscription'])){
            $code_pin = $_POST['pincode_inscription'];
        }
        else{echo '<p>codepin invalid</p>';}
    }
    else{
        echo '<p>Captcha invalid</p>';
    }

} else {
    echo '<p>Something went wrong</p>';
}

?>
/*
if(isset($_POST['captcha_challenge_inscription']) && $_POST['captcha_challenge_inscription'] == $_SESSION['captcha_text']) {



} else {
echo '<p>You entered an incorrect Captcha.</p>';
}
if(isset($_POST['username_inscription']) && strlen($_POST['username_inscription']) < 13 && strlen($_POST['username_inscription']) > 4) {
if (ctype_alnum ($_POST['username_inscription'])=== true ) {
$username = trim(htmlspecialchars($_POST['username_inscription']));
if(!userExists($username)){
echo $username;
}
else{
echo "username existe";
}
}
else{
echo "username with cara";
}
}
if(isset($_POST['password_inscription'])&& strlen($_POST['password_inscription']) < 16 && strlen($_POST['password_inscription']) > 7) {
$password = trim($_POST['password_inscription']);
echo $password;
}

if(isset($_POST['password_confirmed_inscription'])&& strlen($_POST['password_confirmed_inscription']) < 16 && strlen($_POST['password_confirmed_inscription']) > 7) {
$password_confirmed = trim($_POST['password_confirmed_inscription']);
echo $password_confirmed;
}

if(isset($_POST['pincode_inscription']) && strlen($_POST['pincode_inscription']) == 5 ){

if (ctype_digit($_POST['pincode_inscription'])=== true ) {
$code_pin = trim(($_POST['pincode_inscription']));
echo $code_pin;
}
else{
echo "code pin note number";
}
}

*/
