<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--    fichier CSS-->
        <link rel="stylesheet" href="public/css/style.AffichageCommentairesClient.css" />
        <!--    Fin du fichier CSS-->

        <title>Billet simple pour l'Alaska</title>

    </head>
    <body>
       <div id='conteneurCommentaireAccueil'>
        <div id='conteneurCommentaireEnvoit'>
            <form class='elementCommentaireAccueil' name="commentaire" method="post" action="index.php"> 
                <div class='elementCommentaireEnvoit'>
                    <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" value="<?php echo isset($routeur['valeurs']['pseudoClient']) ? $routeur['valeurs']['pseudoClient'] : null;?>">
                </div>
                <div class='elementCommentaireEnvoit'>
                <textarea rows="4" cols="50" name='commentaire' required-maxlenght="1000" placeholder="Ajouter votre commentaire ici"></textarea>
                </div>
                <div id='conteneurBoutonInformation'>
                <div class='elementCommentaireEnvoit'>
                <input type='submit' value="Commenter" >
                <input type="hidden" name="id" id="id" value="<?php echo isset($routeur['valeurs']['idBillet']) ? $routeur['valeurs']['idBillet'] : null; ?>">
                <input type="hidden" name="page" id="page" value="commentaireClient">
                </div>
            </form>
                <span class="error"> <?php echo isset($routeur['valeurs']['PseudoErr']) ? $routeur['valeurs']['PseudoErr'] : null ?></span>
                </div>
            </div>
           <form class='elementCommentaireAccueil' name="retourCLient" method="post" action="index.php"> 
               <input id='BoutonRond' type='submit' value="Accueil" >
                <input type="hidden" name="page" id="page" value="accueilClient">
            </form>
            </div>


           

           
           <div id='conteneurCommentaires'>
            <?php
    foreach(isset($routeur['valeurs']['affichageCommentaire']) ? $routeur['valeurs']['affichageCommentaire'] : null as $traitementCommentaires) {
                echo'<p>'.
                    '<strong>'.$traitementCommentaires['pseudoUtilisateur'].'</strong>'.
                    '</br>'.
                    $traitementCommentaires['commentaireUtilisateur'].
                    '</br>'.
                    'le <em>'.$traitementCommentaires['heureCommentaire_fr'].'</em>'
            ?>
            <form name="signaler" method="post" action="index.php">
                <input type='submit' value="Signaler" > 
                <input type="hidden" name="idUnique" id="idUnique" value='<?php echo $traitementCommentaires['idUnique']; ?>'>
                <input type="hidden" name="id" id="id" value='<?php echo $traitementCommentaires['id'];?>'>
                <input type="hidden" name="page" id="page" value="signalementCommentaire">
            </form>
            <?php
                '</p>';
            }
            ?>
        </div>
    </body>
</html>