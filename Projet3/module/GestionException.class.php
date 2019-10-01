<?php
class MonException extends ErrorException
{
    private $_sType = "";

    public function __construct() {
        switch ($this->severity)
        {
            case E_USER_ERROR : // Si l'utilisateur émet une erreur fatale.
                $this->_sType = 'Erreur fatale';

                break;

            case E_WARNING : // Si PHP émet une alerte.
            case E_USER_WARNING : // Si l'utilisateur émet une alerte.
                $this->_sType = 'Attention';
                break;

            case E_NOTICE : // Si PHP émet une notice.
            case E_USER_NOTICE : // Si l'utilisateur émet une notice.
                $this->_sType = 'Note';
                break;

            case E_DEPRECATED :
                $this->_sType = 'Deprecier';
                break;

            case E_PARSE :
                $this->_sType = 'Erreur Syntaxe';
                break;

            case E_ERROR :
                $this->_sType = 'Erreur critique';
                break;

            case E_STRICT :
                $this->_sType = 'Avertissement';
                break;

            case E_NOTICE :
                $this->_sType ='Information';
                break;

            case E_CORE_XXX :
                $this->_sType = "Erreur Critique Php";
                break;

            case E_COMPILE_XXX :
                $this->_sType ='Erreur de Compilation';
                break;

            default : // Erreur inconnue.
                $this->_sType = 'Erreur inconnue';
                break;
        }

    }


    public function __toString()
    {
        return  (new module\GestionTemps)->heureFrance().' '.$this->_sType . ' : [' . $this->code . '] ' . $this->message ." ". $this->file . ' à la ligne ' . $this->line.PHP_EOL;
    }

    public function enregistrementErreur($e){

        if($this->severity === E_USER_ERROR || E_ERROR){
            error_log($e,1,'wampkarl@gmail.com');}

        error_log($e,3,"Exceptions/".$this->_sType.".txt");
        
        header("Location: vue/Exception.vue.php");


    }
}