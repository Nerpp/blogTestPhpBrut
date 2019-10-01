<html>
    <head>
        <meta charset="UTF-8">
        <title>Administration Mdp</title>
        <link rel = "stylesheet" href = "CSS/style.accueil.css"/>
    </head>
    <body>

        <form name="verificationPin" method="post" action="index.php">

            <div>
                <label for"codePin">Saississez le code Pin envoyé par mail </label>
                <div><input type="text" name="codePin" id="codePin" placeholder="Code Pin" value=""></div>
                <span class="error"> <?php echo isset($routeur['valeurs']['PinErr']) ? $routeur['valeurs']['PinErr'] : null; ?></span>
            </div>
               
            <div><p><input type='submit'</p></div>
            <input type="hidden" name="page" id="page" value="verificationPin">
            <input type="hidden" name="token" id="token" value='<?php echo $_SESSION['token']; ?>'>
        </form>

    </body>
</html>