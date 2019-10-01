<html>
    <head>
        <meta charset="UTF-8">
        <title>Changement Mdp</title>
        <link rel = "stylesheet" href = "public/css/style.VerificationMail.css"/>
    </head>
    <body>
       
        <div id="Titre"><h1>Demande de Nouveau Mot De Passe</h1></div>
       
       <div id="Header">
        <form class="elementHeader" name="envoitMail" method="post" action="index.php">
           <div>
               <p><label for"adresseMail"><strong>Saississez votre Adresse mail</strong></label></p>
               <div><input type="text" name="adresseMail" id="adresseMail" placeholder="@Mail" value=""></div>
               <span class="error"> <?php echo isset($routeur['valeurs']['MailErr']) ? $routeur['valeurs']['MailErr'] : null;?></span>
           </div>
           
            <div><p><input type='submit'value="Soumettre"</p></div>
            <input type="hidden" name="page" id="page" value="verificationMail">
            <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
        </form>
        
           <form class="elementHeader" name="retourCLient" method="post" action="index.php"> 
            <input id='BoutonRond' type='submit' value="Accueil" >
            <input type="hidden" name="page" id="page" value="accueilClient">
        </form>
<!--        fin du conteneurHeader-->
        </div>
<!--        fin du conteneurHeader-->
        
    </body>
</html>