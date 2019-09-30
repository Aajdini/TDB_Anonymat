<?php
/**
 * Created by PhpStorm.
 * User: Artrit
 * Date: 20.09.2019
 * Time: 21:11
 */
session_start();

require '../db/connexion_db.php';
if(isset($_POST['requestShare'])  && !empty($_POST['usernameField']) && isset($_POST['usernameField'])  && !empty($_POST['usernameField']) && isset($_POST['doid'])  && !empty($_POST['doid'])){
        //$_SESSION['invitation_send'] = "Invitation envoyée avec succès !";
        if(saveInvitation($_SESSION['sess_user_id'],$_POST['doid'],$_POST['usernameField'])){
            echo json_encode(array('success' => true));
        }
        else{
            echo json_encode(array('success' => "Nom d'utilisateur inconnu !"));
        }
}


if(isset($_GET['reqRefused'])  && !empty($_GET['reqRefused']) && isset($_GET['iddoc'])  && !empty($_GET['iddoc']) && isset($_GET['invid'])  && !empty($_GET['invid'])  ){
    if(updateInvitation($_GET['invid'],2)){
        $_SESSION['invitation_refused'] = "Invitation refusée !";
        header("Location: ../../tpl/session/home.php");

    }
    else{
        $_SESSION['invitation_refused'] = "Impossible de refusée l'invitation !";
        header("Location: ../../tpl/session/home.php");


    }
}

if(isset($_GET['reqAccepted'])  && !empty($_GET['reqAccepted'])  && isset($_GET['iddoc'])  && !empty($_GET['iddoc']) && isset($_GET['invid'])  && !empty($_GET['invid']) ){
    if(updateInvitation($_GET['invid'],1)){
        $_SESSION['invitation_accepted'] = "Invitation accetpé !";
        saveParticipant($_SESSION['sess_user_id'],$_GET['iddoc']);
        header("Location: ../../tpl/session/home.php");


    }
    else{
        $_SESSION['invitation_accepted'] = "Impossible d'accepter l'invitation !";
        header("Location: ../../tpl/session/home.php");


    }
}


function userExists($name,$id){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $query = "select * from `users` where `username`=:username and id !=:id";
        $stmt = $db->prepare($query);
        $stmt->bindParam('username', $name, PDO::PARAM_STR);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 0 && empty($row)) {
            return null;
        } else {
            return $row['id'];
        }
    } catch (PDOException $e){
        echo $e->getMessage();
        return null;
    }
    $database->closeConnection();
}

function saveInvitation($owner_id,$document_id,$name){
    $database = new Connection();
    $db = $database->openConnection();
    $date = date('Y-m-d H:i:s');
    $statut = 0;
    $userID = userExists($name,$owner_id);
    if($userID!=null){
        try {
            $stmt = $db->prepare('INSERT INTO invitation( owner_id, destinataire_id,document_id,date_creation,statut) VALUES(?,?,?,?,?)');
            $stmt->bindParam('1', $owner_id);
            $stmt->bindParam('2', $userID);
            $stmt->bindParam('3', $document_id);
            $stmt->bindParam('4', $date);
            $stmt->bindParam('5', $statut);
            // echo $name." - ".$generated_name." - ".$destPath." - ".$boolTrue." - ".$date." - ".$date." - ".$boolTrue." - ".$id_owner ;

            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    else{
        return false;
    }
    $database->closeConnection();
}
function updateInvitation($inv_id,$bool){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $query = "UPDATE invitation SET statut = :statut WHERE inv_id = :inv_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam('statut', $bool, PDO::PARAM_INT);
        $stmt->bindParam('inv_id', $inv_id, PDO::PARAM_INT);
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

function saveParticipant($user_id,$doc_id){
    $database = new Connection();
    $db = $database->openConnection();
        try {
            $stmt = $db->prepare('INSERT INTO participant_private(doc_id,user_id) VALUES(?,?)');
            $stmt->bindParam('1', $doc_id);
            $stmt->bindParam('2', $user_id);

            if($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    $database->closeConnection();

}