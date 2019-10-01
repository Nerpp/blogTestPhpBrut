<?php
namespace module;

class Routeur
{
    private $_Parametres = [];
    private $_ValeursVue = [];
    private $_Vue = 'accueil';
    

    private $_Routes = [
        'accueil' => [
            'page'  => 'accueil',
            'vue'   => 'accueil'
        ],
        'administrationMdp' => [
            'page' => 'administrationMdp',
            'vue'  => 'VerificationMail'
        ],
        'verificationMail' => [
            'page' => 'verificationMail',
            'vue'  => 'VerificationMail'
        ],
        'verificationPin' => [
            'page' => 'verificationPin',
            'vue'  => 'VerificationPin'
        ],
        'nouveauMdp' => [
            'page' => 'nouveauMdp',
            'vue'  => 'NouveauMdp'
        ],
        'identification' => [
            'page' => 'identification',
            'vue'  => 'accueil'
        ],
        'nouveauBillet'=> [
            'page' => 'nouveauBillet',
            'vue'  => 'EditeurTexte'
        ],
        'enregistrementBillet'=> [
            'page' => 'enregistrementBillet',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'editionBrouillon'=> [
            'page' => 'editionBrouillon',
            'vue'  => 'EditeurTexte'
        ],
        'effaceBillet'=> [
            'page' => 'effaceBillet',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'avantPublication'=> [
            'page' => 'avantPublication',
            'vue'  => 'AffichageBrouillonAdministrateur'
        ],
        'apresPublication'=> [
            'page' => 'apresPublication',
            'vue'  => 'AffichageBilletAdministrateur'
        ],
        'publicationBillet'=> [
            'page' => 'publicationBillet',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'renvoitBrouillon'=> [
            'page' => 'renvoitBrouillon',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'annulationBillet'=> [
            'page' => 'annulationBillet',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'retourAdmin'=> [
            'page' => 'retourAdmin',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'lectureBillet'=> [
            'page' => 'lectureBillet',
            'vue'  => 'TemplateClient'
        ],
        'commentaireClient'=> [
            'page' => 'commentaireClient',
            'vue'  => 'TemplateClient'
        ],
        'signalementCommentaire'=> [
            'page' => 'signalementCommentaire',
            'vue'  => 'TemplateClient'
        ],
        'autoriserCommentaire'=> [
            'page' => 'autoriserCommentaire',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'suppressionCommentaire'=> [
            'page' => 'suppressionCommentaire',
            'vue'  => 'BienvenueAdministrateur'
        ],
        'deconnexionClient'=> [
            'page' => 'deconnexionClient',
            'vue'  => 'accueil'
        ]
    ];

    public function __construct(Array $tabParametres = null)
    {
        // Si des paramètres ont été transmis
        if(!is_null($tabParametres)) {
            $this->_Parametres = $tabParametres;        
        }
    }
    
    public function getParametre($nomParametre) {
        return isset($this->_Parametres[$nomParametre]) ? $this->_Parametres[$nomParametre] : null;
    }
    
    public function getParametres() {
        return $this->_Parametres;
    }

    private function verifieIdentification() {
        return (!is_null($this->getParametre('token')) && $this->getParametre('token') === $_SESSION['token'] && $_COOKIE['cookieSecurite'] === $_SESSION['securiteCookie']) ? true : false;
    }

    public function getRoute($page) {
        return (!is_null($page) && isset($this->_Routes[$page])) ? $this->_Routes[$page] : null;
    }

    public function resolutionRoute() {
        try
        {
        $tabRoute = [
            'vue'     => $this->_Vue,
            'valeurs' => $this->_ValeursVue
        ];
        
        
            $route = $this->getRoute($this->getParametre('page'));
            switch ($route['page']) {
        
                case 'retourAdmin':
                    if($this->verifieIdentification()){
                    $tabRoute['vue'] = $route['vue'];
                    $objetBillet = new \controleur\BilletControleur;
                    $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                    $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                    $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                    $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                    $objetCommentaire = new \controleur\CommentairesControleur;
                    $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                    $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                    $securisationIdentiter = (new\module\Securite())->tokenTimer();
                    unset($objetBillet);
                    unset($objetCommentaire);
                    unset($securisationIdentiter);
                    break;}
                    
                case 'administrationMdp':
                    $tabRoute['vue'] = $route['vue'];
                    $securisationIdentiter = (new\module\Securite())->securiteCsrf();
                    unset($securisationIdentiter);
                    break;
                
                case 'verificationMail':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $mailIdentification = new \controleur\UtilisateurControleur();
                        if(!$mailIdentification->nouveauMdp($this->getParametre('adresseMail'))){
                            $tabRoute['valeurs']['MailErr'] = $mailIdentification->getMailErr();
                            if(!$mailIdentification->getIdentite() && isset($_SESSION['securite'])){
                                $tabRoute['vue'] = 'ErreurIdentification';}
                        }else{$tabRoute['vue'] = 'VerificationPin';}
                        //pour changer le jeton
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        //unset sert a liberer la memoire
                        unset($securisationIdentiter);
                        unset($mailIdentification);} 
                    break;
                    
                case 'verificationPin':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $verification = new \controleur\UtilisateurControleur();
                        if($verification->verificationPin(intval($this->getParametre('codePin'))) != TRUE){
                            $tabRoute['valeurs']['PinErr'] = $verification->getPinErr();
                            if(!$verification->getIdentite() && isset($_SESSION['securite'])){
                                $tabRoute['vue'] = 'ErreurIdentification';}
                        }else{$tabRoute['vue'] = 'NouveauMdp';}
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($verification);
                        unset($securisationIdentiter);
                        break;}
                    
                case 'nouveauMdp':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $verificationMdp = new \controleur\UtilisateurControleur();
                        if($verificationMdp->validationMdp($this->getParametre('mdp'),
                                                           $this->getParametre('verificationMdp')
                                                                ) != TRUE){
                            $tabRoute['valeurs']['MdpErr']             = $verificationMdp->getMdpErr();
                            $tabRoute['valeurs']['VerificationMdpErr'] = $verificationMdp->getVerificationMdpErr(); 
                        }else{$tabRoute['vue'] = 'accueil';}
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($verification);
                        unset($securisationIdentiter);   
                    break;}
                    
                //verification identité sur l'accueil
                case 'identification':
                    $tabRoute['vue'] = $route['vue'];
                    $objetIdentification = new \controleur\UtilisateurControleur();
                    if($objetIdentification->identifier_utilisateur($this->getParametre('identifiant'), $this->getParametre('mdp')) != TRUE){
                        $tabRoute['valeurs']['identificationErreur'] = $objetIdentification->getIdentificationErr();
                        $tabRoute['valeurs']['MdpErr'] = $objetIdentification->getMdpErr();
                        $tabRoute['valeurs']['IdentifiantErr'] = $objetIdentification->getIdentiantErr();
                        if(!$objetIdentification->getIdentite() && isset($_SESSION['securite'])){$tabRoute['vue'] = 'ErreurIdentification';}
                    }else{
                        $objetBillet = new \controleur\BilletControleur;
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $tabRoute['vue'] = 'BienvenueAdministrateur';}
                    unset($objetIdentification);                  
                    unset($objetCommentaire);                  
                    break;
                    
                case 'nouveauBillet':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $tabRoute['valeurs']['idBillet'] = (new \controleur\BilletControleur)->nouveauBillet('', '', '');
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($securisationIdentiter); 
                        break;}
                    
                case 'enregistrementBillet':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetBillet = new \controleur\BilletControleur;
                        $objetBillet->enregistrementBillet($this->getParametre('chapitre'),
                                                              $this->getParametre('titre'),
                                                              $this->getParametre('texteEditer'),
                                                              $this->getParametre('id')
                                                             );
                        $objetBillet = new \controleur\BilletControleur;
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetBillet); 
                        unset($objetCommentaire); 
                        unset($securisationIdentiter); 
                        break;}
                    
                case 'editionBrouillon':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $affichageBrouillon = new \controleur\BilletControleur;
                        $parametresBrouillon = array();
                        $parametresBrouillon = $affichageBrouillon->affichageBillet($this->getParametre('id'));
                        $tabRoute['valeurs']['idBillet'] = $parametresBrouillon['0']['id'];
                        $tabRoute['valeurs']['chapitreBillet'] = $parametresBrouillon['0']['chapitre'];
                        $tabRoute['valeurs']['titreBillet'] = $parametresBrouillon['0']['titre'];
                        $tabRoute['valeurs']['editionBillet'] = $parametresBrouillon['0']['edition'];
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($securisationIdentiter); 
                        unset($affichageBrouillon); 
                        break;}
                    
                case'effaceBillet':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetBillet = new \controleur\BilletControleur;
                        $objetBillet->suppressionBillet($this->getParametre('id'));
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetBillet);
                        unset($objetCommentaire);
                        unset($securisationIdentiter);
                        break;}
                    
                case 'avantPublication':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetBillet = new \controleur\BilletControleur;
                        $parametresObjet = $objetBillet->affichageBillet($this->getParametre('id'));
                        $tabRoute['valeurs']['idBillet'] = $parametresObjet['0']['id'];
                        $tabRoute['valeurs']['chapitreBillet'] = $parametresObjet['0']['chapitre'];
                        $tabRoute['valeurs']['titreBillet'] = $parametresObjet['0']['titre'];
                        $tabRoute['valeurs']['editionBillet'] = $parametresObjet['0']['edition'];
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetBillet);
                        unset($securisationIdentiter);
                        break;}
                    
                case'apresPublication':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetBillet = new \controleur\BilletControleur;
                        $parametresObjet = $objetBillet->affichageBillet($this->getParametre('id'));
                        $tabRoute['valeurs']['idBillet'] = $parametresObjet['0']['id'];
                        $tabRoute['valeurs']['chapitreBillet'] = $parametresObjet['0']['chapitre'];
                        $tabRoute['valeurs']['titreBillet'] = $parametresObjet['0']['titre'];
                        $tabRoute['valeurs']['editionBillet'] = $parametresObjet['0']['edition'];
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetBillet);
                        unset($securisationIdentiter);
                        break;}
                                   
                case'publicationBillet':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetBillet = new \controleur\BilletControleur;
                        $objetBillet->publicationBillet($this->getParametre('id'));
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetBillet);
                        unset($objetCommentaire);
                        unset($securisationIdentiter);
                        break;}
                    
                case'renvoitBrouillon':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetBillet = new \controleur\BilletControleur;
                        $objetBillet->renvoitBrouillon($this->getParametre('id'));
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetBillet);
                        unset($objetCommentaire);
                        unset($securisationIdentiter);
                        break;}
                    
                case'lectureBillet':
                    $tabRoute['vue'] = $route['vue'];
                    $objetBillet = new \controleur\BilletControleur;
                    $parametresObjet = $objetBillet->affichageBillet($this->getParametre('id'));
                    $tabRoute['valeurs']['idBillet'] = $parametresObjet['0']['id'];
                    $tabRoute['valeurs']['chapitreBillet'] = $parametresObjet['0']['chapitre'];
                    $tabRoute['valeurs']['titreBillet'] = $parametresObjet['0']['titre'];
                    $tabRoute['valeurs']['editionBillet'] = $parametresObjet['0']['edition'];
                    $objetCommentaire = new \controleur\CommentairesControleur;
                    $parametresCommentaires = $objetCommentaire->affichageCommentaires($this->getParametre('id'));
                    $tabRoute['valeurs']['affichageCommentaire'] = $objetCommentaire->affichageCommentaires($this->getParametre('id'));
                    unset($objetBillet);
                    unset($objetCommentaire);
                    break;
                    
                case'commentaireClient':
                    $tabRoute['vue'] = $route['vue'];
                    $objetBillet = new \controleur\BilletControleur;
                    $parametresObjet = $objetBillet->affichageBillet($this->getParametre('id'));
                    $tabRoute['valeurs']['idBillet'] = $parametresObjet['0']['id'];
                    $tabRoute['valeurs']['chapitreBillet'] = $parametresObjet['0']['chapitre'];
                    $tabRoute['valeurs']['titreBillet'] = $parametresObjet['0']['titre'];
                    $tabRoute['valeurs']['editionBillet'] = $parametresObjet['0']['edition'];
                    
                    $objetCommentaire = new \controleur\CommentairesControleur;
                    $verificationPseudo = $objetCommentaire->enregistrementCommentaires($this->getParametre('id'),
                                                                  $this->getParametre('commentaire'),
                                                                  $this->getParametre('pseudo')
                                                                                          );
                    
                    if(!$verificationPseudo) $tabRoute['valeurs']['PseudoErr'] = 'Pseudo/Commentaire Obligatoire';
                    $tabRoute['valeurs']['affichageCommentaire'] = $objetCommentaire->affichageCommentaires($this->getParametre('id'));
                    unset($objetBillet);
                    unset($objetCommentaire);
                    break;
                    
                case'signalementCommentaire':
                    $tabRoute['vue'] = $route['vue'];
                    //je recharge le billet
                    $objetBillet = new \controleur\BilletControleur;
                    $parametresObjet = $objetBillet->affichageBillet($this->getParametre('id'));
                    $tabRoute['valeurs']['idBillet'] = $parametresObjet['0']['id'];
                    $tabRoute['valeurs']['chapitreBillet'] = $parametresObjet['0']['chapitre'];
                    $tabRoute['valeurs']['titreBillet'] = $parametresObjet['0']['titre'];
                    $tabRoute['valeurs']['editionBillet'] = $parametresObjet['0']['edition'];
                    //le commentaire
                    $objetCommentaire = new \controleur\CommentairesControleur;
                    $objetCommentaire->signalementCommentaire($this->getParametre('idUnique'));
                    $tabRoute['valeurs']['affichageCommentaire'] = $objetCommentaire->affichageCommentaires($this->getParametre('id'));
                    unset($objetCommentaire);
                    unset($objetBillet);
                    break;
                    
                case'autoriserCommentaire':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];                        
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $objetCommentaire->autorisationCommentaires($this->getParametre('idUnique'));
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $objetBillet = new \controleur\BilletControleur;
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetCommentaire);
                        unset($securisationIdentiter);
                        break;}
                    
                case'suppressionCommentaire':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $objetCommentaire->suppressionCommentaires($this->getParametre('idUnique'));
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $objetBillet = new \controleur\BilletControleur;
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($objetCommentaire);
                        unset($objetBillet);
                        unset($securisationIdentiter);
                        break;}
                    
                case'annulationBillet':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $objetBillet = new \controleur\BilletControleur;
                        $objetBillet->suppressionBillet($this->getParametre('id'));
                        $tabRoute['valeurs']['sommaireBrouillon'] = $objetBillet->listeBrouillon();
                        $tabRoute['valeurs']['compteurBrouillon'] =  $objetBillet->getBrouillonCompteur();
                        $tabRoute['valeurs']['sommaireBillet'] = $objetBillet->listeBillet();
                        $tabRoute['valeurs']['compteurBillet'] =  $objetBillet->getBilletCompteur();
                        $objetCommentaire = new \controleur\CommentairesControleur;
                        $tabRoute['valeurs']['gestionCommentaire'] = $objetCommentaire->gestionCommentaires();
                        $tabRoute['valeurs']['compteurCommentaire'] = $objetCommentaire->getCommentairesCompteur();
                        $securisationIdentiter = (new\module\Securite())->tokenTimer();
                        unset($securisationIdentiter);
                        unset($objetIdentification);                  
                        unset($objetCommentaire); 
                        break;
                    }
                    
                case'deconnexionClient':
                    if($this->verifieIdentification()){
                        $tabRoute['vue'] = $route['vue'];
                        $securisationIdentiter = new\module\Securite();
                        $securisationIdentiter->tokenTimer();
                        $securisationIdentiter->deconnexionClient();
                        unset($securisationIdentiter);
                        break;}
                
            }
        return $tabRoute;
            
        }//fin du try
        
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
    }
        
}//fin de la classe