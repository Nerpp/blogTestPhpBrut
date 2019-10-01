<?php
function error2exception($code, $message, $fichier, $ligne)
{
    throw new MonException($message,0,$code, $fichier, $ligne);
}

function customException($e)
{
    $oMonException = new MonException();
    $oMonException->enregistrementErreur($e);
}

set_error_handler('error2exception');
set_exception_handler('customException');

