<?php
require '../db/connexion_db.php';
function userExists($username){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $query = "select * from `users` where `username`=:username ";
        $stmt = $db->prepare($query);
        $stmt->bindParam('username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 0 && empty($row)) {
           return false;

        } else {
            return true;
        }

    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
       // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
       // tools('Location: ../../index.php');
    }
    $database->closeConnection();
}
function saveUser($username,$password,$pincode){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $query = "INSERT INTO users (username, password,code_pin) VALUES (:username, :password,:code_pin) ";
        $stmt = $db->prepare($query);
        $stmt->bindParam('username', $username, PDO::PARAM_STR);
        $stmt->bindParam('password', sha1($password), PDO::PARAM_STR);
        $stmt->bindParam('code_pin', sha1($pincode), PDO::PARAM_STR);
        if($stmt->execute()) {
            return true;

        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
        // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
        // tools('Location: ../../index.php');
    }
    $database->closeConnection();
}
function checkPinCode($username,$pincode){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $query = "select * from `users` where `username`=:username AND `code_pin`=:pincode ";
        $stmt = $db->prepare($query);
        $stmt->bindParam('username', $username, PDO::PARAM_STR);
        $stmt->bindParam('pincode', sha1($pincode), PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 0 && empty($row)) {
            return false;

        } else {
            return true;
        }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
        // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
        // tools('Location: ../../index.php');
    }
    $database->closeConnection();
}

function resetPassword($username,$password){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $query = "UPDATE users SET password = :password WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam('username', $username, PDO::PARAM_STR);
        $stmt->bindParam('password', sha1($password), PDO::PARAM_STR);
        if(!$stmt->execute()) {
            return false;
        } else {
            return true;
        }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
        // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
        // tools('Location: ../../index.php');
    }
    $database->closeConnection();
}

function captchaFieldIsValid($text,$text_challenge){
    if(isset($text) && !empty($text) && $text == $text_challenge) {
        return true;
    }
    else{
        return false;
    }

}
function usernameFieldIsValid($text){
    if(isset($text) && !empty($text)  && strlen(trim($text)) < 13 && strlen(trim($text)) > 4) {
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
    if(isset($text) && !empty($text)  && strlen(trim($text)) < 16 && strlen(trim($text)) > 7) {
        return true;
    }
    else{
        return false;
    }

}

function pincodeFieldIsValid($text){
    if(isset($text) && !empty($text)  && strlen(trim($text)) ==5) {
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
    if(isset($text) && !empty($text) && $text == $text2) {
            return true;
        }
        else{
            return false;
        }
}
