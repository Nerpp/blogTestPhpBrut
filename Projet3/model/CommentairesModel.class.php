<?php
namespace model;


class CommentairesModel
{   
    //attributs
    private $_aAffichageCommentaires = array();
    private $_aGestionCommentaires   = array();
    
    private $_sDernierCommentaire    = "";
    private $_sDernierId             = "";
    
    //methodes
    public function getAffichageCommentaires(){
        return $this->_aAffichageCommentaires;
    }
    
    public function getGestionCommentaires(){
        return $this->_aGestionCommentaires;
    }
    
    public function getDernierCommentaire(){
        return $this->_sDernierCommentaire;
    }
    
    public function getDernierId(){
        return $this->_sDernierId;
    }
        
        
    public function enregistrementCommentaires(string $id, string $commentaireUtilisateur,string $pseudoUtilisateur){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $req = $connection->prepare('INSERT INTO commentaire (id,commentaireUtilisateur,pseudoUtilisateur,signalement) 
        VALUES(:id,:commentaireUtilisateur,:pseudoUtilisateur,:signalement)');

            $req->bindValue(':id', $id, \PDO::PARAM_STR);
            $req->bindValue(':commentaireUtilisateur', $commentaireUtilisateur, \PDO::PARAM_STR);
            $req->bindValue(':pseudoUtilisateur', $pseudoUtilisateur, \PDO::PARAM_STR);
            $req->bindValue(':signalement', 'nonSignaler', \PDO::PARAM_STR);

            $req->execute();
            $this->_sDernierId = $connection->lastInsertId();
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
         
    }
    
    
    public function affichageCommentaires(string $id){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();

            $req = $connection->query("Select idUnique,id,commentaireUtilisateur,pseudoUtilisateur,heureCommentaire,DATE_FORMAT(heureCommentaire, '%d/%m/%Y à %Hh%imin%ss') AS heureCommentaire_fr From commentaire WHERE id = '".$id."'  ORDER BY heureCommentaire DESC");

            if($req->rowCount()){
                while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
                {                
                    $this->_aAffichageCommentaires[] = $donnees;
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
    
     public function gestionCommentaires(){
         try
         {
             $bdd = new connectionBdd('projet3','localhost','','root');
             $connection = $bdd->connection();

             $req = $connection->query("Select idUnique,id,commentaireUtilisateur,pseudoUtilisateur,heureCommentaire,DATE_FORMAT(heureCommentaire, '%d/%m/%Y à %Hh%imin') AS heureCommentaire_fr From commentaire WHERE signalement = 'signaler'  ORDER BY heureCommentaire DESC");

             if($req->rowCount()){
                 while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
                 {               
                     $this->_aGestionCommentaires[] = $donnees;
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
    
    public function signalementCommentaire(string $idUnique){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("UPDATE commentaire SET signalement = :signalement WHERE idUnique = '".$idUnique."' ");
            $req->execute(array('signalement' => 'signaler'));
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
    
    }
    
    public function autoriserCommentaires(string $idUnique){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("UPDATE commentaire SET signalement = :signalement WHERE idUnique = '".$idUnique."' ");
            $req->execute(array('signalement' => 'nonSignaler'));
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function suppressionCommentaires(string $idUnique){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->prepare("DELETE FROM commentaire WHERE idUnique = '".$idUnique."' OR id = '".$idUnique."' ");
            $req->execute();
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function verificationReload(string $idUnique){
        try
        {
            $bdd = new connectionBdd('projet3','localhost','','root');
            $connection = $bdd->connection();
            $req = $connection->query("Select commentaireUtilisateur FROM commentaire WHERE idUnique = '".$idUnique."' ");

            while ($donnees = $req->fetch(\PDO::FETCH_ASSOC))
            {                
                $this->_sDernierCommentaire = $donnees;
            }

            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
    }
    
}//fin de classe