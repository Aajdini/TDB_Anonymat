<?php
session_start();
require 'connexion.php';
$error_text = "";
if(isset($_POST['login'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  if($username != "" && $password != "") {
    try {
      $query = "select * from `users` where `username`=:username and `password`=:password";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam('username', $username, PDO::PARAM_STR);
      $stmt->bindValue('password', $password, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->rowCount();
      $row   = $stmt->fetch(PDO::FETCH_ASSOC);
      if($count == 1 && !empty($row)) {
        $_SESSION['sess_user_name'] = $row['username'];
          $_SESSION['sess_user_id']   = $row['id'];
          header('Location: ../../tpl/session/home.php');
      } else {
          $error_text = "Invalid username and password!";
          echo ($error_text);
      }
    } catch (PDOException $e) {
      echo "Error : ".$e->getMessage();
    }
  } else {
      $error_text = "Both fields are required!";
      echo ($error_text);
  }
}
?>
