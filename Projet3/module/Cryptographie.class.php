<?php
namespace module;

class Cryptographie
{
    
    //attribut
    private $_sClef              = '';
    private $_sIv                = '';
    
    //methode
    
    public function getIv(){
        return $this->_sIv;
    }
    
    public function getClef(){
        return $this->_sClef;
    }
    
    public function chiffrement(string $chiffrement){
        try
        {
            //        je definit la methode de chiffrement qui definit la longueur de l'iv et de la clé 
            $method = 'aes-256-cbc';
            //je hache mon mdp
            $mdpHasher = password_hash($chiffrement, PASSWORD_DEFAULT);
            //l'iv va definir la methode de chiffrement
            $this->_sIv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            //la clef va permettre le dechiffrement
            $this->_sClef = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            $resultat = openssl_encrypt ($mdpHasher, $method, $this->_sClef, true, $this->_sIv);
            return $resultat;
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }

    }
    
    public function dechiffrement(string $dechiffrement, string $clefDechiffrement,string $ivDechiffrement){
        try
        {
            $method = 'aes-256-cbc';
            //        string openssl_decrypt ( string $data , string $method , string $password, option OPENSSL_RAW_DATA ou OPENSSL_ZERO_PADDING, $iv )
            $resultatDechiffrement = openssl_decrypt ($dechiffrement, $method , $clefDechiffrement, true, $ivDechiffrement);
            return $resultatDechiffrement; 
        }
        catch (Exception $e)
        {
            $oMonException = new \module\MonException();
            $oMonException->enregistrementErreur($e);
        }
    }
    
}//fin de la classe
