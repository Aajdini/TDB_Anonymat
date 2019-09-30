<?php
session_start();
if (isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] == true) {
    $name_session_usr = $_SESSION['sess_user_name'];
    $name_session_id = $_SESSION['sess_user_id'];
} else {
    header('location:../../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Créer un document</title>
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
        <h1>Création document</h1>
    </div>

    <div class="card sticky-top" id="section_sauvegarde">
        <div class="card-body">
            <div class="alert alert-danger" role="alert" id="alertErrors">

            </div>
            <div class="row">
                <div class="col-7 input-group ">
                    <input type="text" class="form-control input-lg" name="documentName" id="documentName" placeholder="Nom du document *">
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
        data: {
            blocks: [
                {
                    type: "header",
                    data: {
                        text: "Commencer à écrire",
                        level: 2
                    }
                },
                {
                    type : 'paragraph',
                    data : {
                        text : 'Hey. Meet the new Editor.'
                    }
                },
                {
                    type: "header",
                    data: {
                        text: "Exa",
                        level: 3
                    }
                },
                {
                    type : 'list',
                    data : {
                        items : [
                            'C\'est un éditeur de style bloc',
                            'Ajouter de nouveaux blocs ou vous voulez',
                            'Organiser votre document comme vous voulez ',
                        ],
                        style: 'unordered'
                    }
                },

            ]
        },
        onChange: function() {
            console.log('something changed');
        }
    });

    const udd = "<?php echo $_SESSION['sess_user_id'] ?>" ;
    saveButton.addEventListener('click', function () {
        editor.save().then((outputData) => {
            $.ajax({
                contentType: "application/x-www-form-urlencoded; charset=UTF-8", // $_POST
                method: "POST",
                url: "../../inc/editor/pr-doc_func.php",
                data: {data: outputData,filename: doc_name.val(),udd :udd}
            })
                .done(function(data) {
                    datas = JSON.parse(data)
                    if(datas['success'] === true) {
                        window.location.href = ("../session/home.php");
                    }
                    else{
                        div_alert.append(datas['success']);
                        div_alert.show();
                    }
                })
                .fail(function(data) {
                    div_alert.append("Erreur de requête !");
                    div_alert.show();
                });
        }).catch((error) => {
                console.log('Saving failed: ', error);
        });

    });
</script>
</body>
</html>
