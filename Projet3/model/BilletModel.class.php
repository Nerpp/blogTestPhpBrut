<?php
namespace model;

require_once 'ConnectionBDD.class.php';

use model\ConnectionBdd;


class BilletModel
{
    //attribut
    private $_aSommaireBillet      = array();
    private $_aSommaireBrouillon   = array();
    private $_aAffichageBillet     = array();
    private $_iIdBillet            = '';

    //methode
    public function getSommaireBillet(){
        return $this->_aSommaireBillet;
    }
    public function getSommaireBrouillon(){
        return $this->_aSommaireBrouillon;
    }
    
    public function getAffichageBillet(){
        return $this->_aAffichageBillet;
    }
    
    public function getIdBillet(){
        return $this->_iIdBillet;
    }

    public function sommaireBillet(){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $req = $connection->query("Select id,chapitre,titre From billet WHERE etat = 'editer' ORDER BY id ASC ");

            if($req->rowCount()){
                while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
                {                
                    $this->_aSommaireBillet[] = $donnees;
                }
            }
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }

     
    }
    
    public function sommaireBrouillon(){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $req = $connection->query("Select id,chapitre,titre From billet WHERE etat = 'brouillon' ORDER BY id ASC ");

            if($req->rowCount()){
                while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
                {                
                    $this->_aSommaireBrouillon[] = $donnees;
                }
            }
            $req->closeCursor(); 
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
    }
    
    public function nouveauBillet(string $chapitre,string $titre,string $texte ,string $etat){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $req = $connection->prepare('INSERT INTO billet (chapitre,titre,edition,etat) VALUES(:chapitre,:titre,:edition,:etat)');

            $req->bindValue(':chapitre', $chapitre, \PDO::PARAM_STR);
            $req->bindValue(':titre', $titre, \PDO::PARAM_STR);
            $req->bindValue(':edition', $texte, \PDO::PARAM_STR);
            $req->bindValue(':etat', $etat, \PDO::PARAM_STR);

            $req->execute();
            $this->_iIdBillet = $connection->lastInsertId();
            $req->closeCursor(); 
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
       
    }
    
    public function enregistrementBillet(string $chapitre, string $titre, string $edition,string $id){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $req = $connection->prepare("UPDATE billet SET chapitre = :chapitre,titre = :titre,edition = :edition WHERE id = '".$id."' ");
            $req->execute(array(
                'chapitre' => $chapitre,
                'titre' => $titre,
                'edition' => $edition,
            ));

            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
   
    }
    
    public function affichageBillet (string $id){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $req = $connection->query("Select id,chapitre,titre,edition From billet WHERE id ='".$id."'  ");

            if($req->rowCount()){
                while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
                {                
                    $this->_aAffichageBillet[] = $donnees;
                }
            }
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
      
    }
    
    public function suppressionBillet(string $id){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("DELETE FROM billet WHERE id ='".$id."' ");
            $req->execute();
            $req->closeCursor();   
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
             
    }
    
    public function publicationBillet(string $id){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("UPDATE billet SET etat = :etat WHERE id = '".$id."' ");
            $req->execute(array('etat' => 'editer'));
            $req->closeCursor(); 
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function renvoitBrouillon(string $id){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("UPDATE billet SET etat = :etat WHERE id = '".$id."' ");
            $req->execute(array('etat' => 'brouillon'));
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
     
    }
    
    
}//fin de la classe