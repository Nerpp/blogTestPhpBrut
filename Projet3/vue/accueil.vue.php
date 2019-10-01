<html>
    <head>
        <meta charset="UTF-8">
        <title>Billet simple pour l'Alaska</title>
        <link rel = "stylesheet" href = "public/css/style.accueil.css"/>
    </head>
    <body>
            <!--            debut du conteneur Header-->
            <div id = 'conteneurHeader'>
            <!--            debut du conteneur Header-->
              <div id="conteneurTitre">
              <div class = 'elementTitre'><p><h1>Billet</h1></p></div>
              <div class = 'elementTitre'><p><h1>Simple pour l'Alaska</h2></p></div>
              <div class = 'elementTitre'><p><h1>Jean Forteroche</h2></p></div>
              </div>
              <!--              fin du conteneur header-->
              </div>
              <!--              fin du conteneur header-->
              
              
              <!--debut du conteneur-->
              <div id ='conteneurIdentification'>
              <!--debut du conteneur-->
              
              <div id = 'conteneurFormulaire'>
               <form name="identification" method="post" action="index.php">
               <div><input type="text" name="identifiant" id="identifiant" placeholder="Identifiant" value=""></div>
               <div><span class="error"> <?php echo isset($routeur['valeurs']['IdentifiantErr']) ?$routeur['valeurs']['IdentifiantErr'] : null; ?></span></div>
               <div><input type="password" name="mdp" id="mdp" placeholder="Mot de Passe" value=""></div>
                <div><span class="error"> <?php echo isset($routeur['valeurs']['MdpErr']) ? $routeur['valeurs']['MdpErr'] : null; ?></span></div>

                <input type='submit' value = ' Valider'>
                <input type="hidden" name="page" id="page" value="identification">
                   <div><span class="error"><?php echo isset($routeur['valeurs']['identificationErreur']) ?$routeur['valeurs']['identificationErreur'] : null; ?></span></div>
                </form>
                </div>
                
                <div id = 'oublieMdp'>
                <form name="administrationMdp" method="post" action="index.php">
                    <div class="styleOublie"><input id ='styleOublie' type='submit' value='OublieMdp'></div>
                <input type="hidden" name="page" id="page" value="administrationMdp">
                </form>
                </div>
                
                <!--            fin du conteneur conteneurIdentification-->
                </div>
                <!--            fin du conteneur conteneurIdentification-->
                
<!--                debut conteneur sommaire-->
                <div id ='conteneurSommaire'>
<!--                fin conteneur sommaire-->
               
                <div class = 'elementSommaire'><h1>Sommaire</h1></div>
                <div class = 'elementSommaire'>
                <?php
                    foreach(isset($routeur['valeurs']['sommaireBillet']) ? $routeur['valeurs']['sommaireBillet'] :$billet->listeBillet() as $listeTraiter) {
                        echo
                            '<strong>Chapitre: </strong>'.$listeTraiter['chapitre'].
                            '</br>'.
                            '<strong>Titre: </strong>'.$listeTraiter['titre']
                    ?>
                    </div>
                    <div class = 'elementSommaire'>
                    <form class='boutonLire'name="lecture" method="post" action="index.php">
                    <input class ='styleLire' type='submit' value="lire" > 
                    <input type="hidden" name="id" id="id" value='<?php echo $listeTraiter['id']; ?>'>
                    <input type="hidden" name="page" id="page" value="lectureBillet">
                    </form>
                    </div>
                    <div class = 'elementSommaire'>
                    <?php
                    }
                    ?>
                    </div>
<!--                    fin conteneur sommaire-->
                    </div>
<!--                    fin conteneur sommaire -->
    </body>
</html>