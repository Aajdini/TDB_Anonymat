<?php

session_start();

require '../db/connexion_db.php';

if(isset($_POST['requestGetDoc'])  && !empty($_POST['requestGetDoc']) && isset($_POST['owid'])  && !empty($_POST['owid']) && isset($_POST['doid'])  && !empty($_POST['doid'])){
    updateAvailabilityDocument($_POST['doid'],0);
    $doc = getDocument($_POST['owid'],$_POST['doid']);
    if($doc!=null){
        echo $doc;
    }
    else{
        echo json_encode(array('success' => "Document vide !"));
    }

}
if(isset($_POST['requestSaveDoc'])  && !empty($_POST['requestSaveDoc']) && isset($_POST['data'])  && !empty($_POST['data']) && isset($_POST['path'])  && !empty($_POST['path'])&& isset($_POST['doidS'])  && !empty($_POST['doidS']) ){

    saveFile($_POST['data'],$_POST['path']);
    updateAvailabilityDocument($_POST['doidS'],1);
    updateDateLastChange($_POST['doidS']);
    $_SESSION['document_edition'] = "Document modifié!";

}

if(isset($_POST['requestGetPath'])  && !empty($_POST['requestGetPath']) && isset($_POST['owid'])  && !empty($_POST['owid']) && isset($_POST['doid'])  && !empty($_POST['doid']) ){
    echo json_encode(getPath($_POST['doid'],$_POST['owid']));


}
function getPath($doc_id,$owner_id){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $path = null;
        $dataToReturn = null;
        $query = "select path_doc from `doc_private` where `owner_doc_id`=:owner_id and id =:doc_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam('owner_id', $owner_id, PDO::PARAM_INT);
        $stmt->bindParam('doc_id', $doc_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 0 && empty($row)) {
            return null;
        } else {
           return $row['path_doc'];
        }
    } catch (PDOException $e){
        echo $e->getMessage();
        return null;
    }
    $database->closeConnection();
}
function getDocument($owner_id,$doc_id){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $path = null;
        $dataToReturn = null;
        $query = "select * from `doc_private` where `owner_doc_id`=:owner_id and id =:doc_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam('owner_id', $owner_id, PDO::PARAM_INT);
        $stmt->bindParam('doc_id', $doc_id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 0 && empty($row)) {
            return null;
        } else {
            //echo $row['path_doc'];

            return getJSONdataDocument($row['path_doc']);
        }
    } catch (PDOException $e){
        echo $e->getMessage();
        return null;
    }
    $database->closeConnection();
}
function getJSONdataDocument($path){
    if (!file_exists($path)) {
        return null;
    }
    else{
        $json_string = file_get_contents($path);
        return $json_string;
    }
}
function updateDateLastChange($doc_id){
    $database = new Connection();
    $db = $database->openConnection();

    $date = date("Y-m-d");
    try {
        $query =  "UPDATE doc_private SET date_lastChange  =:dateChange WHERE id =:id_doc";
        $stmt = $db->prepare($query);
        $stmt->bindParam('dateChange', $date, PDO::PARAM_STR);
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
function updateAvailabilityDocument($doc_id,$bool){
    $database = new Connection();
    $db = $database->openConnection();
    try {
        $query = "UPDATE doc_private SET is_available  = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam('1', $bool);
        $stmt->bindParam('2', $doc_id);
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
function saveFile($jsondata,$destPath){
    $fp = fopen($destPath, 'w');
    $data = json_encode($jsondata, JSON_UNESCAPED_UNICODE);
    if(fwrite($fp, $data)){
        fclose($fp);
        echo json_encode(array('success' => true));
    }
    else{
        echo json_encode(array('success' => "SAvedFailed !"));
    }

}

