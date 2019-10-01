<html>
    <head>
        <meta charset="UTF-8">
        <title>Administration Mdp</title>
        <link rel = "stylesheet" href = "CSS/style.accueil.css"/>
    </head>
    <body>

        <form name="nouveauMdp" method="post" action="index.php">
               <div>
                <label for"nouveauMdp">Saississez votre nouveau Mot de passe</label>
                   <div><input type="password" name="mdp" id="mdp" placeholder="12 caractéres minimum" value=""></div>
                   <span class="error"> <?php echo isset($routeur['valeurs']['MdpErr']) ? $routeur['valeurs']['MdpErr'] : null; ?></span>
                </div>
               
                <div>
                <label for"nouveauMdp">Verification de votre nouveau Mot de passe</label>
                    <div><input type="password" name="verificationMdp" id="verificationMdp" placeholder="12 caractéres minimum" value=""></div>
                    <span class="error"> <?php echo isset($routeur['valeurs']['VerificationMdpErr']) ? $routeur['valeurs']['VerificationMdpErr'] : null; ?></span>
                </div>
                
                <div><p><input type='submit'</p></div>
                <input type="hidden" name="page" id="page" value="nouveauMdp">
                <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
                
                <h2><strong>Conseil de securité</strong></h2>
                <a href="https://www.ssi.gouv.fr/guide/mot-de-passe/">ANSSI Agence Nationale de la sécurité des systèmes d'information </a>
        </form>
    </body>
</html>