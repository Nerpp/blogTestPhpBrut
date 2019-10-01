<?php
//Systeme de Classement
namespace model;
//L'objet PDO est deja integrer dans PHP faut l'appeler
use \PDO;

class ConnectionBdd
{
    //attributs
    private $_sRoot;
    private $_sMdp;
    private $_sNomServeur;
    private $_sNomBDD;
    //ressource rConnexion
    private $_rConnexion;


    //methodes

    //Constructeur pour passer les attributs en parametre de la classe
    public function __construct(string $_sNomBdd,$_sNomServeur='',$_sMdp='', $_sRoot='')
    {
        $this->_sNomServeur= $_sNomServeur;
        $this->_sNomBdd = $_sNomBdd;
        $this->_sRoot = $_sRoot;
        $this->_sMdp = $_sMdp;
    }
    //getter pour donner l'accés aux autres classes de l'attribut privée
    public function getConnexion()
    {
        return $this->_rConnexion;
    }

    //je defini la valeur de rConnection les ressources que j'utiliserai plus tard
    public function connection()
    {
        try
        {
            //L'objet PDO est deja integré dans PHP
            $this->_rConnexion = new \PDO('mysql:host='.$this->_sNomServeur.';dbname='.$this->_sNomBdd.';charset=utf8',$this->_sRoot,$this->_sMdp,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $this->_rConnexion; 
        }
        catch (PDOException $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
        
    }

}//fin de la classe
