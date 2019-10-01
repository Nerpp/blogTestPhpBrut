<?php
namespace controleur;

/**
 * Class IdentificationController permettant de gérer l'identification de l'utilisateur
 * @package controller
 */
class UtilisateurControleur
{

    // Attributs
    //ceux que j'utilisent
    private $_sIdentifiantErr       = '';
    private $_sMdpErr               = '';
    private $_sMailErr              = '';
    private $_sStockagePin          = '';
    private $_sPinErr               = '';
    private $_sVerificationMdpErr   = '';
    private $_sIdentificationErr    = '';
    private $_bIdentite             = '';

    // Méthodes
    
    //identification erreur
    public function getIdentificationErr()
    {
        return $this->_sIdentificationErr;
    }
    
    public function getIdentiantErr()
    {
        return $this->_sIdentifiantErr   ;
    }
    
    //erreur Mdp
    public function getMdpErr()
    {
        return $this->_sMdpErr;
    }
    
    //verification Mdp
    public function getVerificationMdpErr()
    {
        return $this->_sVerificationMdpErr;
    }
    
    
    //mail erreur
    public function getMailErr(){
        return $this->_sMailErr;
    }
    
    //identité utilisateur
    public function getIdentite()
    {
        return $this->_bIdentite;
    }
    //Code Pin Err
    public function getPinErr()
    {
        return $this->_sPinErr;
    }
         

//    identification du client
    public function identifier_utilisateur(string $identifiant, string $mdp){
        try
        {
            //J'initialise l'objet securité
            $securite = new \module\Securite();
            $controleurId = $securite->testInput($identifiant);
            $controleurMdp = $securite->testInput($mdp);

            //Verification si les champs sont vide
            if(empty($identifiant)){
                $this->_sIdentifiantErr = 'Veuillez renseigner votre Identifiant'; }
            if(empty($mdp)){
                $this->_sMdpErr = 'Veuillez renseigner votre mot de passe';}


            //inutile d'aller plus loin si les deux champs sont vide
            if(!empty($controleurId) && !empty($controleurMdp)){

                //je verifie que l'identifiant est bien une adresse mail
                if (filter_var($controleurId, FILTER_VALIDATE_EMAIL)){

                    $verification = new \model\UtilisateurModel();
                    $verification->donneeUtilisateur('email',$controleurId);
                    $aDonneeUtilisateur = $verification->getDonnee();

                    if($controleurId === $aDonneeUtilisateur['email']){
                        $verification->verrouilleurChiffrement($aDonneeUtilisateur['email']);
                        $aClefUtilisateur = $verification->getClef();

                        //                    je dechiffre le mdp
                        $mdpDechiffrer =(new \module\Cryptographie())->dechiffrement($aDonneeUtilisateur['mdp'],
                                                                                     $aClefUtilisateur['cle'],
                                                                                     $aClefUtilisateur['iv']
                                                                                    );
                        //                    je verifie le hashage
                        if (password_verify($controleurMdp,$mdpDechiffrer)) {

                            $_SESSION["heureConnexion"] = $aDonneeUtilisateur['heureConnexion'];
                            $_SESSION["identite"]   = $aDonneeUtilisateur['pseudonyme'];

                            //je recupere la date en francais                        
                            $gestionTemps = (new \module\GestionTemps())->heureFrance();

                            $verification->updateHeure($aDonneeUtilisateur['email'],$gestionTemps);
                            //                        je met en place le token et la verification par cookie
                            $securite->securiteCsrf();
                            //je prepare l'affichage des brouillons

                            return TRUE;
                        }else{$this->_sIdentificationErr = "Accés Refusé";
                              $this->_bIdentite = $securite->limiteValidation();
                             }
                    }else{$this->_sIdentificationErr = "Accés Refusé";
                          $this->_bIdentite = $securite->limiteValidation();}
                }else{$this->_sIdentificationErr = "Accés Refusé";
                      $this->_bIdentite = $securite->limiteValidation();}           
            }
            return FALSE;   
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
    //changer le mdp
    public function nouveauMdp(string $mail){
        try
        {
            $securite = new \module\Securite();
            $verificationMail=$securite->testInput($mail);

            if(!empty($verificationMail)){
                if(filter_var($verificationMail, FILTER_VALIDATE_EMAIL)){
                    $verification = new \model\UtilisateurModel();
                    $verification->donneeUtilisateur('email',$verificationMail);
                    $aDonneeUtilisateur = $verification->getDonnee();
                    if($aDonneeUtilisateur){
                        $creationPin = random_int(100000, 999999);
                        $mailAdmin   = $aDonneeUtilisateur['email'];
                        $mailTitre   = 'Code de Verification';
                        $mailMessage = 'le code de Confirmation pour reinitialiser votre mot de passe '.$creationPin;
                        $mailMessageHtml = "<html><head></head><body><b>Le code de confirmation </b>pour reinitialiser votre mot de passe </body></html>".$creationPin;
                        $envoitMail = (new \module\GestionMail())->envoitMail($mailAdmin,
                                                                              $mailTitre,
                                                                              $mailMessage,
                                                                              $mailMessageHtml);
                        $_SESSION['identifiant']    = $aDonneeUtilisateur['id'];
                        $_SESSION['pinCode']        = $creationPin;
                        return TRUE;
                    }else{$this->_sMailErr = "Accés rejetté";
                          $this->_bIdentite = $securite->limiteValidation();}
                }else{$this->_sMailErr = 'Email invalide';
                      $this->_bIdentite = $securite->limiteValidation();}
            }else{$this->_sMailErr = 'Veuillez renseigner votre Email';}
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
       
    }
    
    
    public function verificationPin(int $codePin ){
        try
        {
            $codePin = filter_var($codePin, FILTER_SANITIZE_NUMBER_INT);

            $options = array(
                'options' => array(
                    'min_range' => 100000,
                    'max_range' => 999999
                )
            );
            //je verifie pas si codePin a une identité de 0 car filter_var ne considere pas 0 comme un int
            if(filter_var($codePin, FILTER_VALIDATE_INT,$options) === $_SESSION['pinCode'] ){
                return TRUE;
            }else{$this->_sPinErr = 'Erreur';
                  $this->_bIdentite = (new \module\Securite())->limiteValidation();}
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
       
    }
    
    public function validationMdp(string $mdp, string $verificationMdp){
        try
        {
            if(empty($mdp)){
                $this->_sMdpErr = 'Vide';
            }
            if(empty($verificationMdp)){
                $this->_sVerificationMdpErr = 'Vide';
            }

            if(!empty($mdp) && !empty($verificationMdp) && $mdp === $verificationMdp){

                if(mb_strlen($verificationMdp) >= 12){

                    //je chiffre le mdp verifier
                    $chiffrement = new \module\Cryptographie();
                    $mdpChiffre = $chiffrement->chiffrement($verificationMdp);

                    //Update la clef et l'iv pour ca il me faut recuperer le mail
                    $update = new \model\UtilisateurModel();
                    $update->donneeUtilisateur('id',$_SESSION['identifiant']);
                    $aDonneeUtilisateur = $update->getDonnee();

                    $update->updateVerouillage($chiffrement->getClef(),
                                               $chiffrement->getIv(),
                                               $aDonneeUtilisateur['email'] );
                    //                je sauvegarde le nouveau mdp
                    $update->updateMdp($aDonneeUtilisateur['email'],$mdpChiffre);

                    $mailAdmin   = $aDonneeUtilisateur['email'];
                    $mailTitre   = 'Confirmation de changement de code';
                    $mailMessage = 'Le site Bienvenue en Alaska confirme que Votre mot de passe a bien été reinitialisé';
                    $mailMessageHtml = "<html><head></head><body>Le site Bienvenue en Alaska confirme que Votre mot de passe a bien été réinitialisé</body></html>";
                    $envoitMail = (new \module\GestionMail())->envoitMail($mailAdmin,
                                                                          $mailTitre,
                                                                          $mailMessage,
                                                                          $mailMessageHtml);

                    return TRUE;
                }else{$this->_sMdpErr = 'Le mot de passe doit contenir 12 caracteres minimum';} 

            }else{
                if($mdp != $verificationMdp){
                    $this->_sMdpErr = 'Le mot de passe est different de sa verification';
                    $this->_sVerificationMdpErr = 'La verification est differente du mot de passe';
                }
            }
            return FALSE; 
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }
    
}//fin de la classe