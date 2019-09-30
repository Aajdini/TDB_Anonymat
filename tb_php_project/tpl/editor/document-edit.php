<?php
session_start();
if (isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] == true) {
    $name_session_usr = $_SESSION['sess_user_name'];
    $name_session_id = $_SESSION['sess_user_id'];
} else {
    header('location:../../index.php');
}

if(isset($_GET['doid'])  && !empty($_GET['doid']) && isset($_GET['doname'])  && !empty($_GET['doname']) && isset($_GET['owidShared'])  && !empty($_GET['owidShared']) ){

    $udd = $_GET['owidShared'];

}
else {
    $udd = $_SESSION['sess_user_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editer un document</title>
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="../css/document-base.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<?php
require("../navbar-footer/navbar.php");
?>
<div class="container">
    <div class="page-header">
        <h1>Edition document</h1>
    </div>

    <div class="card sticky-top" id="section_sauvegarde">
        <div class="card-body">
            <div class="alert alert-danger" role="alert" id="alertErrors">

            </div>
            <div class="row">
                <div class="col-7 input-group ">
                   <h4>
                    <?php if(isset($_GET['doname'])){
                        echo $_GET['doname'];
                        unset($_GET['doname']);
                    }
                     else{
                        echo("not set");
                     }
                     ?>
                   </h4>
                </div>
                <div class="col input-group ">
                    <button type="button" class="btn btn-primary btn-block" id="saveDocument">Sauvegarder et quitter</button>
                </div>
            </div>
        </div>
    </div>

    <div class="ce-example" id="section_document">
        <div class="ce-example__content _ce-example__content--small">
            <div id="editorjs"></div>

        </div>

    </div>


</div>
<script src="../js/jquery-3.4.1.js" ></script>
<script src="../js/propper-1.15.0.min.js" ></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/editorjs/tools/bundle_header.js"></script><!-- Header -->
<script src="../js/editorjs/tools/bundle_list.js"></script><!-- List -->
<script src="../js/editorjs/tools/bundle_quote.js"></script><!-- Quote -->
<script src="../js/editorjs/tools/bundle_code.js"></script><!-- Code -->
<script src="../js/editorjs/tools/bundle_link.js"></script><!-- Link -->
<script src="../js/editorjs/tools/bundle_paragraph.js"></script><!-- Para -->
<script src="../js/editorjs/tools/bundle_embed.js"></script>
<script src="../js/editorjs/tools/editorjs.js"></script>
<script>
    const div_alert = $("#alertErrors");
    const doc_name = $("#documentName");
    div_alert.hide();

    const saveButton = document.getElementById('saveDocument');
    const udd = "<?php echo $udd ?>" ;
    const doid = "<?php echo $_GET['doid'] ?>" ;


    var return_dataJSON = function () {
        var tmp = null;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': "../../inc/editor/pr-doc-edit_func.php",
            'data': { 'requestGetDoc': "get_doc", 'doid': doid, 'owid': udd },
            'success': function (data) {

                tmp = data;
            }
        });
        return tmp;
    }();


    var getPath = function () {
        var tmp = null;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': "../../inc/editor/pr-doc-edit_func.php",
            'data': { 'requestGetPath': "get_path", 'doid': doid, 'owid': udd },
            'success': function (data) {
                tmp = data;
            }
        });
        return tmp;
    }();

    function saveDoc (data,path) {
        var tmp = null;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': "../../inc/editor/pr-doc-edit_func.php",
            'data': { 'requestSaveDoc': "saveDoc", 'data': data, 'path': path,'doidS': doid },
            'success': function (data) {
                tmp = data;
            }
        });
        return tmp;
    };

    console.log(return_dataJSON);
    var result = JSON.parse(return_dataJSON);
    var editor = new EditorJS({
        /**
         * Wrapper of Editor
         */
        holder: 'editorjs',
        /**
         * Tools list
         */
        tools: {
            /**
             * Each Tool is a Plugin. Pass them via 'class' option with necessary settings {@link docs/tools.md}
             */
            header: {
                class: Header,
                inlineToolbar: ['link'],
                config: {
                    placeholder: 'Header'
                },
                shortcut: 'CMD+SHIFT+H'
            },
            /**
             * Or pass class directly without any configuration
             */
            list: {
                class: List,
                inlineToolbar: true,
                shortcut: 'CMD+SHIFT+L'
            },
            quote: {
                class: Quote,
                inlineToolbar: true,
                config: {
                    quotePlaceholder: 'Enter a quote',
                    captionPlaceholder: 'Quote\'s author',
                },
                shortcut: 'CMD+SHIFT+O'
            },

            code: {
                class:  CodeTool,
                shortcut: 'CMD+SHIFT+C'
            },

            linkTool: LinkTool,
        },
        /**
         * This Tool will be used as default
         */
        // initialBlock: 'paragraph',
        /**
         * Initial Editor data
         */
        data:result,
        onChange: function() {
            console.log('something changed');

        }
    });

    saveButton.addEventListener('click', function () {
        editor.save().then((outputData) => {

            //getpath(id,owner_id)
            var savedoc = JSON.parse(saveDoc(outputData,JSON.parse(getPath)));
            if(savedoc['success'] === true) {
                window.location.href = ("../session/home.php");
            }
            else{
                div_alert.append("Une erreur s'est produite ! ");
                div_alert.show();
            }
    }).catch((error) => {

            div_alert.append("Une erreur s'est produite ! ");
            div_alert.show();
    });
    });


</script>
</body>
</html>
