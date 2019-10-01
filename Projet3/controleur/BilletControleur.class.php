<?php
namespace controleur;



class BilletControleur
{
    private $_sCompteurCommentaire = '';
    private $_sCompteurBillet      = '';
    
    public function getBrouillonCompteur(){
        return $this->_sCompteurBrouillon ;
    }
    
    public function getBilletCompteur(){
        return $this->_sCompteurBillet ;
    }
    
    //Methodes
    
    public function listeBillet(){
        try
        {
            $liste = new \model\BilletModel;
            $liste->sommaireBillet();
            $tableauBillet = $liste->getSommaireBillet();

            if(!empty($tableauBillet)){
                $this->_sCompteurBillet = count($tableauBillet).' Billet redigé(s)';
            }else{$this->_sCompteurBillet = 'Aucun Billet redigé';}

            return $tableauBillet;  
        }
        
        catch (Exception $e)
        {
            $oMonException = new MonException();
            $oMonException->enregistrementErreur($e);
        }
             
    }
    
    public function listeBrouillon(){
        
        try
        {
            $liste = new \model\BilletModel;
            $liste->sommaireBrouillon();
            $tableauBrouillon = $liste->getSommaireBrouillon();

            if(!empty($tableauBrouillon)){
                $this->_sCompteurBrouillon = count($tableauBrouillon).' Brouillon(s) en attente';
            }else{$this->_sCompteurBrouillon = 'Aucun Brouillon en attente';}    
            return $tableauBrouillon;
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
    
    }
    
    public function nouveauBillet(string $chapitre, string $titre, string $edition){
        try
        {
            $initialisationBillet = new \model\BilletModel();
            $initialisationBillet->nouveauBillet($chapitre,$titre,$edition,'brouillon');
            return $initialisationBillet->getIdBillet(); 
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function enregistrementBillet(string $chapitre, string $titre, string $edition, string $id){
        try
        {
            (new \model\BilletModel)->enregistrementBillet($chapitre,$titre,$edition,$id);
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function affichageBillet(string $id){
        try
        {
            $affichage = new \model\BilletModel;
            $affichage->affichageBillet($id);
            return $affichage->getAffichageBillet();
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function suppressionBillet(string $id){
        try
        {
            //suppression Billet
            (new\model\BilletModel)->suppressionBillet($id);
            //suppression des commentaires
            (new\model\CommentairesModel)->suppressionCommentaires($id);
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
       
    }
    
    public function publicationBillet(string $id){
        try
        {
            (new\model\BilletModel)->publicationBillet($id);   
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    public function renvoitBrouillon(string $id){
        try
        {
            (new\model\BilletModel)->renvoitBrouillon($id);    
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
}//fin de la classe