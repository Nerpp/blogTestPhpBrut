<?php
namespace module;

class GestionTemps
{
    public function heureFrance(){
        date_default_timezone_set('Europe/Paris');
        $heureFrance = date("g:i a");
        setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
        $dateFrance = strftime("%A %d %B");
        $annee = strftime("%Y"); 
        return $heureInstant =  $dateFrance .' '.$heureFrance .' '.$annee;}
}//fin de la classe