<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--    fichier CSS-->
        <link rel="stylesheet" href="public/css/style.editeurTexte.css" />
        <!--    Fin du fichier CSS-->
        <title>Mon éditeur de Texte</title>
        <script src="vendor/tinymce/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: '#mytextarea',
                autoresize_min_height: 600,
                plugins: "textcolor colorpicker autoresize",
                toolbar: "forecolor backcolor undo redo | styleselect | bold italic | link image alignleft aligncenter alignright",
                theme: 'modern',
                branding: false
            });
        </script>
        </head>
        <body>
        
        <div id='conteneurTitre'>
        <h1>Editeur de Texte</h1>
        </div>
        
        <div id ='conteneurAnnulation'>
            <form action="index.php" onsubmit="return confirmation();" method="post">
            <input type="hidden" name="page" id="page" value="annulationBillet">
            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>">
                <input type="hidden" name="id" id="id" value="<?php echo isset($routeur['valeurs']['idBillet']) ? $routeur['valeurs']['idBillet'] : null; ?>">
            <input class='boutonSuppression' type="submit" value="Supprimer">
            </form>
        </div>
            
        <form action="index.php" method="post">
           
           <div id='conteneurPresentation'>
           <div class='elementPresentation'><label for"chapitre"><strong>Chapitre</strong></label>
           <input type="text" name="chapitre" id="chapitre" placeholder="Chapitre" value="<?php echo isset($routeur['valeurs']['chapitreBillet']) ? $routeur['valeurs']['chapitreBillet'] : null; ?>"></div>
            
            <div class='elementPresentation'><label for"titre"><strong>Titre paragraphe</strong></label>
                <input type="text" name="titre" id="titre" placeholder="Titre" value="<?php echo isset($routeur['valeurs']['titreBillet']) ? $routeur['valeurs']['titreBillet'] : null; ?>"></div>
            </div>

           <div id='conteneurTextArea'>
               <textarea id="mytextarea" name="texteEditer" ><?php echo isset($routeur['valeurs']['editionBillet']) ? $routeur['valeurs']['editionBillet'] : null; ?></textarea>
            <input type="hidden" name="page" id="page" value="enregistrementBillet">
            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>">
               <input type="hidden" name="id" id="id" value="<?php echo isset($routeur['valeurs']['idBillet']) ? $routeur['valeurs']['idBillet'] : null; ?>">
            <input type="submit" value="Enregistrer">
            </div>
        </form>
        
            <!--script js-->
            <script src="public/js/confirmation.js"></script>
            <!--script js-->
    </body>
</html>