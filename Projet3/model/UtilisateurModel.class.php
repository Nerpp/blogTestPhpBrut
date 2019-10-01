<?php
//Systeme de Classement
namespace model;


require_once 'ConnectionBDD.class.php';

use model\ConnectionBdd;


class UtilisateurModel
{

    private $_aDonneeUtilisateur = array();
    private $_aCleUtilisateur    = array();



    // Méthodes

    public function getIdentifiant(){
        return $this->_sVerificationIdentifiant;
    }

    public function getPseudonyme(){
        return $this->_sVerificationPseudonyme;
    }

    public function getDonnee(){
        return $this->_aDonneeUtilisateur;
    }

    public function getClef(){
        return $this->_aCleUtilisateur;
    }

    public function donneeUtilisateur(string $identifieur,string $identifiant){
  
        try
        {
            //connection a la bdd
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            if($identifieur === 'email'){
                $reponse = $connection->query("SELECT id,pseudonyme,email,mdp,horaire,heureConnexion FROM utilisateur WHERE email = '".$identifiant."' "); 
            }  
            if($identifieur === 'id'){
                $reponse = $connection->query("SELECT id,pseudonyme,email,mdp,horaire,heureConnexion FROM utilisateur WHERE id = '".$identifiant."' ");
            }

            $this->_aDonneeUtilisateur = $reponse->fetch();
            $reponse->closeCursor();  
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
     
    }
    //je recupere l'iv et la clef
    public function verrouilleurChiffrement(string $identifiant){
        try
        {
            //connection a la bdd
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $reponse = $connection->query("SELECT cle,iv FROM clef WHERE email = '".$identifiant."' "); 

            $this->_aCleUtilisateur = $reponse->fetch();
            $reponse->closeCursor(); 
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
       
    }
    
    //updater le mdp
    public function updateMdp(string $identifiant,string $mdp){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("UPDATE utilisateur SET mdp = :mdp WHERE email = '".$identifiant."' ");
            $req->bindValue(':mdp', $mdp, \PDO::PARAM_STR);
            $req->execute();
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
//    updater IV et Clef de chiffrement
    public function updateVerouillage(string $cle, string $iv, string $identifiant ){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("UPDATE clef SET cle = :cle, iv = :iv WHERE email = '".$identifiant."' ");
            $req->bindValue(':cle', $cle, \PDO::PARAM_STR);
            $req->bindValue(':iv', $iv, \PDO::PARAM_STR);
            $req->execute();
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
//    j'update l'heure de connexion sous 
    public function updateHeure(string $identifiant,string $temps){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("UPDATE utilisateur SET heureConnexion = :temps WHERE email = '".$identifiant."' ");
            $req->bindValue(':temps', utf8_encode($temps), \PDO::PARAM_STR);
            $req->execute();
            $req->closeCursor(); 
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
    }
    
    

}//fin de la classe
