<?php
namespace module;



class Securite{
    
    //attribut
    private $_aParametres        = array();

    //Methodes
    
    public function getParametres(){
        return $this->_aParametres;
    }
    
    //je recupere les post et get et je fait une verification
    public function recuperationUrl()
    {
        try
        {
            if(isset($_POST) && count($_POST) > 0) {   // Informations contenues dans le $_POST
                foreach($_POST as $index => $valeur) {
                    $this->_aParametres[$index] = $valeur;}
                return $valeur;
            }
            else if(isset($_GET) && count($_GET) > 0) {   // Informations contenues dans le $_GET
                foreach($_GET as $index => $valeur) {
                    $this->_aParametres[$index] = $valeur;}
                return $valeur;
            }
        }
        catch (Exception $e)
        {
            $oMonException = new MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    //securisation url
    public function securiteUrl(string $url){
        try
        {
            $url = filter_var($url, FILTER_SANITIZE_URL); 
            return $url; 
        }
        catch (Exception $e)
        {
            $oMonException = new MonException();
            $oMonException->enregistrementErreur($e);
        }
       
    }
    
    //je verifie les entrées bdd
    public function testInput(string $value)
    {
        try{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);

    return $value;}
        catch (Exception $e)
        {
            $oMonException = new MonException();
            $oMonException->enregistrementErreur($e);
        }
    }
    
    
    //Gestion faille CSRF "Cross-Site Request Forgeries" && man in the middle
    public function securiteCsrf(){
        try
        {
            //        je verifie a quel ordinateur je parle
            $valeurSecurite = bin2hex(openssl_random_pseudo_bytes(32));
            $_SESSION['securiteCookie'] = $valeurSecurite;
            //je le store chez le client
            setcookie('cookieSecurite', $valeurSecurite, 0);

            //        je crée une session unique dependament du cookie
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
            //heure de stockage
            $_SESSION['token_time'] = time();  
        }
        catch (Exception $e)
        {
            $oMonException = new MonException();
            $oMonException->enregistrementErreur($e);
        }

    }
    
    //toutes les 10 minutes je change le jeton
    public function tokenTimer(){
        try
        {
            $timestamp_ancien = time();
            //je decompte le temps en minute
            $minuteur = ($timestamp_ancien - $_SESSION['token_time'])/60;

            //variable du delai d'utilisation en minute
            $delaisToken = '10';

            if($minuteur >= $delaisToken ){
                //stocke nouveau jeton
                $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                //heure de stockage du nouveau jeton
                $_SESSION['token_time'] = time();
            }
        }
        catch (Exception $e)
        {
            $oMonException = new MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function limiteValidation(){
         try
         {
             //            initialisation
             if(!isset($_SESSION['securite'])){$_SESSION['securite'] = 0;}

             if(isset($_SESSION['securite']) && $_SESSION['securite'] < 3){
                 $_SESSION['securite']++;
             }else{return FALSE;}
             return TRUE; 
         }
        catch (Exception $e)
        {
            $oMonException = new MonException();
            $oMonException->enregistrementErreur($e);
        }

    }
    
   public function deconnexionClient(){
       try
       {
           session_destroy();
           setcookie('cookieSecurite','', -3600);   
       }
       catch (Exception $e)
       {
           $oMonException = new MonException();
           $oMonException->enregistrementErreur($e);
       }
          
   }
        
}//fin de la classe