<?php
session_start();

require '../db/connexion_db.php';

if( isset($_GET['doid'])  && !empty($_GET['doid'])){

    if(deleteDocument($_GET['doid'])){
        $_SESSION['docDeleted'] = "Suppression réussi !" ;
        header('Location: ../../tpl/session/home.php');
    }
    else{
        $_SESSION['deleteErreur'] = "Erreur lors de la suppression" ;
    }

}
else{
    $_SESSION['deleteErreur'] = "Erreur lors de la suppression" ;
}

function deleteDocument($doc_id){
    $database = new Connection();
    $db = $database->openConnection();
    $bool = 0;
    $date = date("Y-m-d");
    try {
        $query =  "UPDATE doc_private SET is_enabled  =:is_enabled WHERE id =:id_doc";
        $stmt = $db->prepare($query);
        $stmt->bindParam('is_enabled', $bool, PDO::PARAM_STR);
        $stmt->bindParam('id_doc', $doc_id, PDO::PARAM_INT);
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