<?php
session_start();
require("user_func.php");
$error_text = [];
$database = new Connection();
$db = $database->openConnection();
if(isset($_POST['login'])) {
    if(captchaFieldIsValid($_POST['captcha_challenge_inscription'],$_SESSION['captcha_text'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        echo trim($_POST['password']);
        if ($username != "" && $password != "") {
            try {
                $query = "select * from `users` where `username`=:username and `password`=:password";
                $stmt = $db->prepare($query);
                $stmt->bindParam('username', $username, PDO::PARAM_STR);
                $stmt->bindValue('password', sha1($password), PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($count == 1 && !empty($row)) {
                    $_SESSION['sess_user_name'] = $row['username'];
                    $_SESSION['sess_user_id'] = $row['id'];
                    header('Location: ../../tpl/session/home.php');
                } else {
                    $_SESSION['identification_erreur'] = "Nom d'utilisateur ou mot de passe invalide !";
                    header('Location: ../../index.php');
                }
            } catch (PDOException $e) {
                echo "Error : " . $e->getMessage();
                // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
                // tools('Location: ../../index.php');
            }
        } else {
            $_SESSION['identification_erreur_champs'] = "Merci de compléter les champs !";
            header('Location: ../../index.php');
        }
    }
    else{
        $_SESSION['identification_erreur_captcha'] = "Captcha invalide !";
        header('Location: ../../index.php');
    }
}
$database->closeConnection();

