<?php
namespace controleur;


class CommentairesControleur
{
    private $_sCompteurCommentaire = '';
    //methodes
    
    public function getCommentairesCompteur(){
        return $this->_sCompteurCommentaire;
    }
    
    public function enregistrementCommentaires(string $id, string $commentaire,string $pseudo){
        try
        {
            if(!empty($pseudo) && !empty($commentaire) ){

                $securite = new\module\Securite;
                $commentairesSecuriser = $securite->testInput($commentaire);
                $pseudoSecuriser = $securite->testInput($pseudo);

                $objetCommentaire = new\model\CommentairesModel;

                if(!isset($_SESSION['noreload'])){
                    $objetCommentaire->enregistrementCommentaires($id,$commentairesSecuriser,$pseudoSecuriser);
                    $_SESSION['noreload'] = $objetCommentaire->getDernierId();
                    return TRUE;
                }else{
                    $objetCommentaire->verificationReload($_SESSION['noreload']);
                    if($objetCommentaire->getDernierCommentaire()["commentaireUtilisateur"] != $commentaire){
                        $objetCommentaire->enregistrementCommentaires($id,$commentairesSecuriser,$pseudoSecuriser);
                        $_SESSION['noreload'] = $objetCommentaire->getDernierId();
                        return TRUE;
                    }
                }
            }else{return FALSE;} 
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
     
    }
    
    //affichage commentaire sans distinction
    public function affichageCommentaires(string $id){
        try
        {
            $affichage = new \model\CommentairesModel;
            $affichage->affichageCommentaires($id);
            return $affichage->getAffichageCommentaires(); 
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    //affichage commentaire signaler
    public function gestionCommentaires(){
        try
        {
            $affichage = new \model\CommentairesModel;
            $affichage->gestionCommentaires();
            $tableauAffichage = $affichage->getGestionCommentaires();
            if(!empty($tableauAffichage)){
                $this->_sCompteurCommentaire = count($tableauAffichage).' Commentaire(s) signalé';
            }else{$this->_sCompteurCommentaire = 'Aucun Commentaire signaler';}
            return $tableauAffichage;
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
       
    }
    
    public function signalementCommentaire(string $idUnique){
        try
        {
            (new \model\CommentairesModel)->signalementCommentaire($idUnique);
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function autorisationCommentaires(string $idUnique){
        try
        {
            (new \model\CommentairesModel)->autoriserCommentaires($idUnique);
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function suppressionCommentaires(string $idUnique){
        try
        {
            (new \model\CommentairesModel)->suppressionCommentaires($idUnique);   
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
}//fin de la classe