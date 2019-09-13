<?php

require 'connexion.php';

function userExists($username){
    $response = false;
    try {
        $query = "select * from `users` where `username`=:username ";
        $stmt = getPDO()->prepare($query);
        $stmt->bindParam('username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 1 && !empty($row)) {
           return $response;
        } else {
            $response = true;
            return $response;
        }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
    }
}
function captchaFieldIsValid($text,$text_challenge){
    if(isset($text) && $text == $text_challenge) {
        return true;
    }
    else{
        return false;
    }

}
function usernameFieldIsValid($text){
    if(isset($text) && strlen(trim($text)) < 13 && strlen(trim($text)) > 4) {
        if (ctype_alnum (trim($text))=== true ) {

            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }

}

function passwordFieldIsValid($text){
    if(isset($text) && strlen(trim($text)) < 16 && strlen(trim($text)) > 7) {
        return true;
    }
    else{
        return false;
    }

}

function pincodeFieldIsValid($text){
    if(isset($text) && (trim($text)) ==5) {
        if (ctype_digit($text)=== true ) {
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }

}

function samePassword($text,$text2){
    if ($text === $text2) {
        return true;
    }
    else {
        return false;
    }

}
