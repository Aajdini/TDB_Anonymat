<?php
/**
 * Created by PhpStorm.
 * User: Artrit
 * Date: 18.09.2019
 * Time: 16:19
 */
session_start();

require '../db/connexion_db.php';

if($_POST) {
    $docname = "";
    $owner_ID ="";
    $errors_array = [];
        //username
        if(docuNameFieldIsValid($_POST['filename'])){
            $docname = $_POST['filename'];
        }
        else{
            $errors_array["nameFormatError"] = "Format nom de document invalide !";
            echo json_encode(array('success' => "Format nom de document invalide !"));
            exit;
        }

        if(isset($_POST['udd']) && !empty($_POST['udd'])){
            $ownerID = ($_POST['udd']);
        }
        else{
            $errors_array["userIDError"] = "ID utilisateur invalide !";
            echo json_encode(array('success' => "ID utilisateur invalide !"));
            exit;
        }
        $data = json_encode($_POST['data'], JSON_UNESCAPED_UNICODE);

        if(empty($errors_array)){

            if(saveDocument($docname,$ownerID,$data)){
                $_SESSION['document_creation'] = "Document crée et enregistré !";
                echo json_encode(array('success' => true));
                exit;
            }
            else{
               /* $error_data = json_encode($errors_array);
                echo $error_data;*/

                echo json_encode(array('success' => "Impossible de sauvegarder le document !"));
                exit;
            }
        }
        else{
           /* $error_data = json_encode($errors_array);
            echo $error_data;*/
            echo json_encode(array('success' => "Plusieurs erreurs !"));
            exit;
        }

} else {
   /* $errors_array["requestError"] = "Erreur de requête !";
    $error_data = json_encode($errors_array);
    echo $error_data;*/
    echo json_encode(array('success' => "Erreur de requête!"));
    exit;
}



function saveDocument($name,$id_owner,$data){
    $database = new Connection();
    $db = $database->openConnection();
    $date = date('Y-m-d H:i:s');
    $generated_name = get_unique_ref($db);
    $boolTrue = true;
    $path = "../../editor/docs/";
    $destPath = $path.$generated_name.".json";

    if(saveFile($data,$destPath)){
        try {
            $stmt = $db->prepare('INSERT INTO doc_private(doc_name, generated_name, path_doc,is_enabled,date_creation,date_lastChange,is_available,owner_doc_id) VALUES(?,?,?,?,?,?,?,?)');
            $stmt->bindParam('1', $name);
            $stmt->bindParam('2', $generated_name);
            $stmt->bindParam('3', $destPath);
            $stmt->bindParam('4', $boolTrue);
            $stmt->bindParam('5', $date);
            $stmt->bindParam('6', $date);
            $stmt->bindParam('7', $boolTrue);
            $stmt->bindParam('8', $id_owner);
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

function saveFile($jsondata,$destPath){

    $fp = fopen($destPath, 'w');
    if(fwrite($fp, $jsondata)){
        fclose($fp);
        return true;
    }
    else{
        return false;
    }

   /* if (file_put_contents($destPath, $jsondata))
        return true;
    else
        return false;*/
}


function generate_ref(){
    $invID = "DOC-";
    $invID = str_pad($invID, 10, mt_rand(10000,99999), STR_PAD_RIGHT);
    return $invID;
}

function get_unique_ref($db){
    $random_ref = generate_ref();
    $dbb = $db;
   /* $database = new Connection();
    $db = $database->openConnection();*/
    try {
        $query = "select id from `doc_private` where `generated_name`=:randomref ";
        $stmt = $db->prepare($query);
        $stmt->bindParam('randomref', $random_ref, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $row   = $stmt->fetch(PDO::FETCH_ASSOC);
        if($count == 0 && empty($row)) {
            return $random_ref;

        } else {
            get_unique_ref($dbb);
        }

    } catch (PDOException $e) {
        echo "Error : ".$e->getMessage();
        // $_SESSION['pdo_exception'] = "Erreur de connexion avec la base de données !";
        // tools('Location: ../../index.php');
    }
  //  $database->closeConnection();
}
function docuNameFieldIsValid($text){
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