<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--    fichier CSS-->
        <link rel="stylesheet" href="public/css/style.AffichageBilletClient.css" />
        <!--    Fin du fichier CSS-->

        <title>Billet simple pour l'Alaska</title>

    </head>
    <body>
<!--      debut du conteneur-->
       <div id = 'conteneurAffichage'>
<!--      debut du conteneur-->
       
           <div class='elementConteneur'><h1>Chapitre <?php echo isset($routeur['valeurs']['chapitreBillet']) ? $routeur['valeurs']['chapitreBillet'] : null; ?></h1></div>
           <div class='elementConteneur'><h1>titre <?php echo isset($routeur['valeurs']['titreBillet']) ? $routeur['valeurs']['titreBillet'] : null; ?></h1></div>
           <div class='elementConteneur'><p><?php echo isset($routeur['valeurs']['editionBillet']) ? $routeur['valeurs']['editionBillet'] : null; ?></p></div>
        
<!--        fin du conteneur-->
        </div>
<!--        fin du conteneur-->


    </body>
</html>