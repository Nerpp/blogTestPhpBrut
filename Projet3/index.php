<?php
session_start();
header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
header('Content-Type: text/html; charset=utf-8');

// Chargement des dépendances
require_once 'controleur/UtilisateurControleur.class.php';
require_once 'controleur/BilletControleur.class.php';
require_once 'controleur/CommentairesControleur.class.php';

require_once 'model/UtilisateurModel.class.php';
require_once 'model/BilletModel.class.php';
require_once 'model/CommentairesModel.class.php';

require_once 'module/Securite.class.php';
require_once 'module/Routeur.class.php';
require_once 'module/Cryptographie.class.php';
require_once 'module/GestionMail.class.php';
require_once 'module/GestionTemps.class.php';
require_once 'module/GestionException.class.php';

require_once 'module/Configuration.php';


// Espaces de nom utilisés
use controleur\UtilisateurControleur;
use controleur\BilletControleur;

use model\UtilisateurModel;
use model\BilletModel;

use module\Securite;
use module\Routeur;
use module\Cryptographie;
use module\GestionTemps;

use module\GestionException;

// Initialisation des valeurs

//parametres page
$vueCourante            = '';
$parametres             = array();
$parametres['page']     = '';


//Initialisation classes a utiliser
$verificationSecurite       = new Securite();
$chiffrement                = new Cryptographie();
$billet                     = new BilletControleur();


/**
* Gestion parametres[]
*/ 

//trigger_error("Test interception exception", E_USER_ERROR);

try
{

// traitement des parametres et verification du client à qui l'on transmet les infos
if (!is_null($verificationSecurite->recuperationUrl()) ) {  
    $parametres = $verificationSecurite->getParametres();
}

$urlRouter = new Routeur($parametres);
$routeur = $urlRouter->resolutionRoute();

/**
 * Appel à la vue correspondante
 */
$fichierVue = 'vue/' . $verificationSecurite->securiteUrl($routeur['vue']). '.vue.php';
if (file_exists($fichierVue) && $fichierVue != 'index.php') {
    include $fichierVue;
}
    
}//fin du try

catch (Exception $e)
{
    $oMonException = new MonException();
    $oMonException->enregistrementErreur($e);
}