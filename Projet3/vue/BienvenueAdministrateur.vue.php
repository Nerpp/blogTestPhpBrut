<html>
       <head>
       <meta charset="UTF-8">
       <title>Page d'administration</title>
           <link rel = "stylesheet" href = "public/css/style.BienvenueAdministrateur.css"/>
       </head>
       <body>
         <!--         debut conteneur-->
          <div id="conteneurEnTete">
          <!--         debut conteneur-->
          <div class = 'elementEnTete'><h1>Bienvenue <?php echo $_SESSION["identite"];?></h1></div>
          <div class = 'elementEnTete'><strong>Dernière connexion</strong> : <?php echo $_SESSION["heureConnexion"]; ?></div>
          <!--          fin du conteneur-->
          </div>
           <!--          fin du conteneur-->
           
           <div id='conteneurDeconnexion'>
           <form class = 'elementEnTete'action="index.php" method="post">
               <input type="hidden" name="page" id="page" value="deconnexionClient">
               <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>">
               <input type="hidden" name="id" id="id" value="<?php echo isset($routeur['valeurs']['idBillet']) ? $routeur['valeurs']['idBillet'] : null; ?>">
               <input class='boutonDeconnexion' type="submit" value="Déconnexion">
           </form>
           </div>
           
           
           <!--         debut conteneur-->
           <div id = 'conteneurNouveauBillet'>
           <!--         debut conteneur-->
           <div class = 'elementNouveauBillet'><h2>Nouveau Billet</h2></div>
           <div class = 'elementNouveauBillet'>
           <form name="nouveauBillet" method="post" action="index.php">
           <input type='submit' value="creerBillet" >
           <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
           <input type="hidden" name="page" id="page" value="nouveauBillet">
           </form>
           </div>
           <!--          fin du conteneur-->
           </div>
           <!--          fin du conteneur-->
           
               
           
<!--           debut du conteneur conteneurAffichage-->
           <div id ='conteneurAffichage'>
<!--           debut du conteneur conteneurAffichage-->
         
         <div class ='elementAffichage'>
         
<!--          debut conteneurBrouillon-->
           <div id ='conteneurBrouillon'>
<!--          debut conteneurBrouillon-->
            <div class ='elementBrouillon'><h2>Sommaire Brouillon</h2></div>
            <div class ='elementBrouillon'><p> <?php echo isset($routeur['valeurs']['compteurBrouillon']) ? $routeur['valeurs']['compteurBrouillon'] : null; ?></p></div>
             <div class ='elementBrouillon'>
              <?php
                   foreach(isset($routeur['valeurs']['sommaireBrouillon']) ? $routeur['valeurs']['sommaireBrouillon'] : null as $listeBrouillon) {
                  echo
                      'Chapitre: '.$listeBrouillon['chapitre'].
                      '</br>'.
                      'Titre: '.$listeBrouillon['titre']
                      ?>
              <form name="editer" method="post" action="index.php">
                  <input type='submit' value="Editer" > 
                  <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                  <input type="hidden" name="id" id="id" value='<?php echo $listeBrouillon['id']; ?>'>
                  <input type="hidden" name="page" id="page" value="editionBrouillon">
              </form>
                 <form name="delete" method="post" onsubmit="return confirmation();" action="index.php">
                  <input type='submit' value="Delete" > 
                  <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                  <input type="hidden" name="id" id="id" value='<?php echo $listeBrouillon['id']; ?>'>
                  <input type="hidden" name="page" id="page" value="effaceBillet">
              </form>
                 <form name="Appercu" method="post"  action="index.php">
                  <input type='submit' value="Appercu" > 
                  <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                  <input type="hidden" name="id" id="id" value='<?php echo $listeBrouillon['id']; ?>'>
                  <input type="hidden" name="page" id="page" value="avantPublication">
              </form>
               
                     <?php
                      ;
              }
              ?>
               </div>
<!--               fin conteneurBrouillon-->
               </div>
<!--               fin conteneurBrouillon-->
               </div>
               
               <div class ='elementAffichage'>
               <p><h2>Sommaire Billet</h2></p>
               <div><p><?php echo isset($routeur['valeurs']['compteurBillet']) ? $routeur['valeurs']['compteurBillet'] : null; ?></p></div>
                 
             
                 
                 <!--              debut conteneurBillet-->
                  <div id ='conteneurBillet'>
                  <!--              debut conteneurBillet-->
                  
              <div class ='elementBillet'>
              <?php
                  foreach(isset($routeur['valeurs']['sommaireBillet']) ? $routeur['valeurs']['sommaireBillet'] : null as $listeTraiter) {
                      echo
                          '<strong>Chapitre: </strong>'.
                          '</br>'.$listeTraiter['chapitre'].
                          '</br>'.
                          '<strong>Titre: </strong>'.
                          '</br>'.$listeTraiter['titre']
                  ?>
                  </div>
                  <div class ='elementBillet'>
                  <form name="editer" method="post" action="index.php">
                  <input type='submit' value="Editer" > 
                  <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                  <input type="hidden" name="id" id="id" value='<?php echo $listeTraiter['id']; ?>'>
                  <input type="hidden" name="page" id="page" value="editionBrouillon">
                  </form>
                  <form name="delete" method="post" onsubmit="return confirmation();" action="index.php">
                  <input type='submit' value="Delete" > 
                  <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                  <input type="hidden" name="id" id="id" value='<?php echo $listeTraiter['id']; ?>'>
                  <input type="hidden" name="page" id="page" value="effaceBillet">
                  </form>
                  <form name="Appercu" method="post"  action="index.php">
                  <input type='submit' value="Appercu" > 
                  <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                  <input type="hidden" name="id" id="id" value='<?php echo $listeTraiter['id']; ?>'>
                  <input type="hidden" name="page" id="page" value="apresPublication">
                  </form>
                </div>
                 
                <div class ='elementBillet'>
                  <?php
                      ;
                  }
                  ?>
               </div>
                 
                  
<!--                  fin du conteneurBillet-->
                  </div>
<!--                  fin du conteneurBillet -->
         

          
           </div>


           <div class ='elementAffichage'>
<!--           debut conteneurGestionCommentaire-->
                  <div id='conteneurGestionCommentaire'>
<!--           debut conteneurGestionCommentaire-->
                  
                  <div><p><h2>Gestion Commentaire</h2></p></div>
                  <div><p>
                      <div><p> <?php echo isset($routeur['valeurs']['compteurCommentaire']) ? $routeur['valeurs']['compteurCommentaire'] : null; ?></p></div>
                  <?php
                      foreach(isset($routeur['valeurs']['gestionCommentaire']) ? $routeur['valeurs']['gestionCommentaire'] : null as $traitementGestions) {
                          echo'<p>'.
                              '<strong>'.$traitementGestions['pseudoUtilisateur'].'</strong>'.
                              '</br>'.
                              $traitementGestions['commentaireUtilisateur'].
                              '</br>'.
                              'le <em>'.$traitementGestions['heureCommentaire_fr'].'</em>'
                      ?>
                      <form name="supprimer" method="post" onsubmit="return confirmation();" action="index.php">
                      <input type='submit' value="Supprimer" > 
                      <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                      <input type="hidden" name="idUnique" id="idUnique" value='<?php echo $traitementGestions['idUnique']; ?>'>
                      <input type="hidden" name="page" id="page" value="suppressionCommentaire">
                      </form>
                      <form name="autoriser" method="post"  action="index.php">
                      <div><p><input type='submit' value='Autoriser'></p></div>
                      <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                      <input type="hidden" name="idUnique" id="idUnique" value="<?php echo $traitementGestions['idUnique']; ?>">
                      <input type="hidden" name="page" id="page" value="autoriserCommentaire">
                      </form>
                      <?php
                          '</p>';
                      }
                      ?>
                      </p></div>
<!--           fin conteneurGestionCommentaire-->
                    </div>
<!--           fin conteneurGestionCommentaire-->
                   </div>
                    
<!--                    fin du conteneurAffichage-->
                    </div>
<!--                    fin du conteneurAffichage-->

<!--script js-->
<script src="public/js/confirmation.js"></script>
<!--script js-->
       </body>
</html>