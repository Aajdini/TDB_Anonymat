<?php
session_start();
/*if(!isset($_SESSION['sess_user_id'])&& !isset($_SESSION['sess_user_name'])) {
    header('location:../../index.php');
}
else{
    $name_session_usr = $_SESSION['sess_user_name'];
    $name_session_id = $_SESSION['sess_user_id'];
}*/
require("../../inc/editor/pr-home_func.php");

$data = null;
if (isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] == true) {
    $name_session_usr = $_SESSION['sess_user_name'];
    $name_session_id = $_SESSION['sess_user_id'];
    $data = getPrivateDoc($_SESSION['sess_user_id']);
    $data_invitation = getInvitation($_SESSION['sess_user_id']);
    $data_doc_shared = getPrivateSharedDoc($_SESSION['sess_user_id']);
    //$data_shared =

} else {
    header('location:../../index.php');
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="../js/fontawesome.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Espace privée</title>
  </head>
  <body>
  <?php
    require("../navbar-footer/navbar.php");
  ?>
  <div class="page-header">
      <h1>Vos documents privées</h1>
  </div>
  <div class=" h-100">
      <div class="row">

          <div class="col-sm-6">
              <div class="card">
                  <div class="card-header">
                      <h5 class="card-title">Mes documents <a href="../editor/document-base.php" class="btn btn-primary float-right" role="button" aria-pressed="true">Créer nouveau document</a></td></h5>

                  </div>
                  <div class="card-body">
                      <?php if(isset($_SESSION['document_creation'])){?>
                          <div class="alert alert-primary" role="alert">
                              <strong>Bravo !</strong>
                              <?php echo $_SESSION['document_creation'];?> <br>
                              <?php unset($_SESSION['document_creation']);?> <br>
                          </div>
                      <?php } ?>
                      <?php if(isset($_SESSION['document_edition'])){?>
                          <div class="alert alert-primary" role="alert">
                              <strong>Bravo !</strong>
                              <?php echo $_SESSION['document_edition'];?> <br>
                              <?php unset($_SESSION['document_edition']);?> <br>
                          </div>
                      <?php } ?>
                      <?php if(isset($_SESSION['docDeleted'])){?>
                          <div class="alert alert-primary" role="alert">
                              <strong>Bravo !</strong>
                              <?php echo $_SESSION['docDeleted'];?> <br>
                              <?php unset($_SESSION['docDeleted']);?> <br>
                          </div>
                      <?php } ?>
                      <?php if(isset($_SESSION['deleteErreur'])){?>
                          <div class="alert alert-primary" role="alert">
                              <strong>Oups !</strong>
                              <?php echo $_SESSION['deleteErreur'];?> <br>
                              <?php unset($_SESSION['deleteErreur']);?> <br>
                          </div>
                      <?php } ?>
                      <?php if(isset($_SESSION['invitation_accepted'])){?>
                          <div class="alert alert-primary" role="alert">
                              <strong>Bravo !</strong>
                              <?php echo $_SESSION['invitation_accepted'];?> <br>
                              <?php unset($_SESSION['invitation_accepted']);?> <br>
                          </div>
                      <?php } ?>
                      <?php if(isset($_SESSION['invitation_refused'])){?>
                          <div class="alert alert-primary" role="alert">
                              <strong>Bravo !</strong>
                              <?php echo $_SESSION['invitation_refused'];?> <br>
                              <?php unset($_SESSION['invitation_refused']);?> <br>
                          </div>
                      <?php } ?>
                      <table class="table table-responsive table-striped">
                          <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nom</th>
                              <th scope="col">Date de création</th>
                              <th scope="col">Date dernière modification</th>
                              <th scope="col">Edition</th>
                              <th scope="col">Suppression</th>
                              <th scope="col">Partage</th>
                          </tr>
                          </thead>
                          <tbody>
                         <?php
                         if($data == !null) {
                             foreach ($data as $row) {
                                 ?>
                                 <tr>
                                     <th scope="row">1</th>
                                     <td><?php echo $row['doc_name']; ?> </td>
                                     <td><?php echo date("d-m-Y", strtotime($row['date_creation'])) ?> </td>
                                     <td><?php echo date("d-m-Y", strtotime($row['date_lastChange'])) ?> </td>
                                     <?php if($row['is_available']==1){ ?>
                                         <td><a href="../editor/document-edit.php?doid=<?php echo $row['id']; ?>&doname=<?php echo $row['doc_name']; ?>" class="btn btn-success" role="button"
                                                aria-pressed="true">Editer</a></td>
                                         <td><a class="btn btn-danger" role="button"
                                                aria-pressed="true" data-toggle="modal" data-target="#delModal<?php echo $row['id']; ?>">Supprimer</a></td>

                                     <?php } else{ ?>
                                         <td><a  class="btn btn-secondary" role="button"
                                                aria-disabled="true" >Occupé</a></td>
                                         <td><a  class="btn btn-secondary" role="button"
                                                 aria-disabled="true" >Occupé</a></td>
                                     <?php }  ?>



                                     <td><a class="btn btn-secondary" role="button" aria-pressed="true" data-toggle="modal" data-target="#shareModal<?php echo $row['id']; ?>">Partager</a>
                                     </td>
                                 </tr>
                                 <!-- Modal delete  -->
                                 <div class="modal fade" id="delModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deletemodal" aria-hidden="true">
                                     <div class="modal-dialog" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="deletemodal">Confirmer suppression</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                 </button>
                                             </div>
                                             <div class="modal-footer">
                                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                 <a class="btn btn-danger" href="../../inc/editor/pr-doc_del.php?doid=<?php echo $row['id']; ?>" role="button">Supprimer</a>

                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- Modal share  -->
                                 <div class="modal fade modalshare" id="shareModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="shareingmodal" aria-hidden="true">
                                     <div class="modal-dialog" role="document">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h5 class="modal-title" id="shareingmodal">Paratger ce document</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                     <span aria-hidden="true">&times;</span>
                                                 </button>

                                             </div>
                                             <div class="alert alert-primary alertdiv" role="alert" id="alertErrors">

                                             </div>
                                             <div class="modal-footer">

                                                     <div class="col-7 input-group ">
                                                         <input type="text" class="form-control input-lg usernameField" name="usernameField" id="usernameField<?php echo $row['id']; ?>" placeholder="Nom de l'utilisateur">
                                                     </div>
                                                     <div class="col input-group ">
                                                         <button class="btn btn-success btn-block btnPartager" role="button" onclick="checkUser(<?php echo $row['id']; ?>)" type="submit" id="btnPartager" name="btnPartager">Partager</button>
                                                     </div>

                                             </div>

                                         </div>
                                     </div>
                                 </div>
                             <?php }
                         }
                         else{
                             ?>
                             <tr>
                                 <th scope="row">1</th>
                                 <td><?php echo "Aucun document" ?> </td>
                             </tr>
                             <?php
                         }

                        ?>

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="col-sm-6">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">Invitation à collaborer</h5>
                      <table class="table table-striped">
                          <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nom</th>
                              <th scope="col">Demande faite par</th>
                              <th scope="col">Date</th>
                              <th scope="col">Statut</th>
                          </tr>
                          </thead>
                          <tbody>
                 <?php if($data_invitation == !null) {
                     foreach ($data_invitation as $row) {
                         ?>
                         <tr>
                             <th scope="row">1</th>
                             <td><?php echo $row['doc_name']; ?></td>
                             <td><?php echo $row['username']; ?></td>
                             <td><?php echo date("d-m-Y", strtotime($row['date_creation'])) ?></td>
                             <td><a href="../../inc/editor/pr-doc-invitation.php?reqAccepted=accepter&iddoc=<?php echo $row['id'];?>&invid=<?php echo $row['inv_id'];?>" class="btn btn-success" role="button" aria-pressed="true">Accepter</a>
                             <a href="../../inc/editor/pr-doc-invitation.php?reqRefused=refuser&iddoc=<?php echo $row['id']; ?>&invid=<?php echo $row['inv_id'];?>" class="btn btn-danger" role="button" aria-pressed="true">Refuser</a></td>
                         </tr>
                     <?php }
                 }
                 else{
                     ?>
                     <tr>
                         <th scope="row">1</th>
                         <td><?php echo "Aucune invitation" ?> </td>
                     </tr>
                     <?php
                 }

                 ?>

                          </tbody>
                      </table>
                  </div>

                  <div class="card-body">
                      <h5 class="card-title">Partagé avec moi </h5>
                      <table class="table table-striped">
                          <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nom</th>
                              <th scope="col">Date de création</th>
                              <th scope="col">Date dernière modification</th>
                              <th scope="col">Edition</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php if($data_doc_shared == !null) {
                              foreach ($data_doc_shared as $row) {
                                  ?>
                                  <tr>
                                      <th scope="row">1</th>
                                      <td><?php echo $row['doc_name']; ?> </td>
                                      <td><?php echo date("d-m-Y", strtotime($row['date_creation'])) ?> </td>
                                      <td><?php echo date("d-m-Y", strtotime($row['date_lastChange'])) ?> </td>
                                      <?php if($row['is_available']==1){ ?>
                                          <td><a href="../editor/document-edit.php?doid=<?php echo $row['id']; ?>&doname=<?php echo $row['doc_name']; ?>&owidShared=<?php echo $row['owner_doc_id']; ?>" class="btn btn-success" role="button"
                                                 aria-pressed="true">Editer</a></td>
                                      <?php } else{ ?>
                                          <td><a  class="btn btn-secondary" role="button"
                                                  aria-disabled="true" >Occupé</a></td>
                                      <?php }  ?>
                                  </tr>
                              <?php }
                          }
                          else{
                              ?>
                              <tr>
                                  <th scope="row">1</th>
                                  <td><?php echo "Aucun document" ?> </td>
                              </tr>
                              <?php
                          }

                          ?>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>

  </div>



    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.4.1.js" ></script>
    <script src="../js/propper-1.15.0.min.js" ></script>
    <script src="../js/bootstrap/bootstrap.min.js"></script>
    <script>
       // const div_alert = $("#alertErrors");
        const div_alert = $(".alertdiv");
        const btn_patager = $(".btnPartager");
        div_alert.hide();
       const inputUsername = $(".usernameField");
       var str1 =  "#usernameField";

        function checkUser(doid){
            div_alert.empty();
            var inputid = str1.concat(doid);
            $.ajax({
                'async': false,
                'type': "POST",
                'global': false,
                'dataType': 'html',
                'url': "../../inc/editor/pr-doc-invitation.php",
                'data': { 'requestShare': "request_share", 'doid': doid, 'usernameField' : $(inputid).val() },
                'success': function (data) {
                    var datas = JSON.parse(data);
                    if(datas['success'] === true) {
                        div_alert.append(" Invitation envoyée !");
                        div_alert.show();
                    }
                    else{
                        div_alert.append(datas['success']);
                        div_alert.show();
                        console.log(data);

                    }
                },
                'error': function(result) {
                    alert('error');
                }
            });

        }
        $('.modalshare').on('hidden.bs.modal', function () {
            div_alert.hide();
            div_alert.empty();
            inputUsername.val("");
            btn_patager.attr('disabled', true);
        });
        $(document).ready(function(){
            btn_patager.attr('disabled',true);
            inputUsername.keyup(function(){
                if($(this).val().length !==0)
                    btn_patager.attr('disabled', false);
                else
                    btn_patager.attr('disabled',true);
            })
        });






    </script>

  </body>
</html>

<?php



?>