<?php
require '../../inc/db/connexion_db.php';

//getPrivateSharedDoc;
function getPrivateDoc($userID){
   // echo($userID);
    $database = new Connection();
    $db = $database->openConnection();
    $bool = 1;
    try {
        $query = "select * from doc_private where owner_doc_id=:userid and is_enabled=:is_enabled";
        $stmt = $db->prepare($query);
        $stmt->bindParam('userid', $userID, PDO::PARAM_INT);
        $stmt->bindParam('is_enabled', $bool, PDO::PARAM_INT);
        if($stmt->execute()){
            $row   = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        }
        else{
            return null;
        }

    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
        // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
        // tools('Location: ../../index.php');
    }
    $database->closeConnection();
}

function getPrivateSharedDoc($id_user){
// echo($userID);
    $database = new Connection();
    $db = $database->openConnection();
    $bool = 1;
    try {
        $query = ('
        SELECT dp.*
        FROM doc_private dp
        JOIN participant_private pa ON pa.doc_id = dp.id
        where pa.user_id =:userid and dp.is_enabled =:statut
        ');
        $stmt = $db->prepare($query);
        $stmt->bindParam('userid', $id_user, PDO::PARAM_INT);
        $stmt->bindParam('statut', $bool, PDO::PARAM_INT);
        if($stmt->execute()){
            $row   = $stmt->fetchAll(PDO::FETCH_ASSOC);
           // print_r($row);
            return $row;
        }
        else{
            return null;
        }
    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
        // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
        // tools('Location: ../../index.php');
    }
    $database->closeConnection();

}
function getInvitation($id_user){
    $database = new Connection();
    $db = $database->openConnection();
    $int = 0;
    try {
        //$query = "select * from `invitation` where `destinataire_id`=:dest and statut =:statut";
        $query = '
        SELECT inv.*,doc.*,u.username
        FROM invitation inv
        JOIN doc_private doc ON inv.document_id = doc.id
        JOIN users u ON inv.owner_id = u.id
        where inv.destinataire_id =:dest and inv.statut =:statut
        ';
        $stmt = $db->prepare($query);
        $stmt->bindParam('dest', $id_user, PDO::PARAM_STR);
        $stmt->bindParam('statut', $int, PDO::PARAM_INT);
        if($stmt->execute()){
            $row   = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($row);
            return $row;
        }
        else{
            return null;
        }
    } catch (PDOException $e){
        echo $e->getMessage();
        return null;
    }
    $database->closeConnection();
}

function setInvitaitonResponse(){


}

