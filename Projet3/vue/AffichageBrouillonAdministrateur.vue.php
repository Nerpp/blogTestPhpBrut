<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--    fichier CSS-->
        <link rel="stylesheet" href="public/css/style.AffichageBilletAdministrateur.css" />
        <!--    Fin du fichier CSS-->

        <title>Billet simple pour l'Alaska</title>

    </head>
    <body>

        <div id='conteneurEntete'>
            <div class='elementEntete'><h1>Chapitre <?php echo isset($routeur['valeurs']['chapitreBillet']) ? $routeur['valeurs']['chapitreBillet'] : null;?></h1></div>
            <div class='elementEntete'><h1>titre <?php echo isset($routeur['valeurs']['titreBillet']) ? $routeur['valeurs']['titreBillet'] : null; ?></h1></div>
            <div class='elementEntete'><p><?php echo isset($routeur['valeurs']['editionBillet']) ? $routeur['valeurs']['editionBillet'] : null; ?></p></div>
        </div>
        <div id='conteneurOption'><p>
            <form class='elementOption'name="Publication" method="post" action="index.php">
                <input type='submit' value='Publier'>
                <input type="hidden" name="page" id="page" value="publicationBillet">
                <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                <input type="hidden" name="id" id="id" value="<?php echo isset($routeur['valeurs']['idBillet']) ? $routeur['valeurs']['idBillet'] : null; ?>">
            </form>
            <form class='elementOption' name="Editer" method="post" action="index.php">
                <input type='submit' value='Editer'>
                <input type="hidden" name="page" id="page" value="editionBrouillon">
                <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                <input type="hidden" name="id" id="id" value="<?php echo isset($routeur['valeurs']['idBillet']) ? $routeur['valeurs']['idBillet'] : null; ?>">
            </form>
            <form class='elementOption' name="Retour" method="post" action="index.php">
                <input type='submit' value='Retour'>
                <input type="hidden" name="page" id="page" value="retourAdmin">
                <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
            </form>
            </p></div>
    </body>
</html>