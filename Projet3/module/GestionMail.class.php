<?php 
namespace module;
//https://openclassrooms.com/courses/e-mail-envoyer-un-e-mail-en-php


class GestionMail
{
    
    
    public function envoitMail(string $mailAdmin,string $mailTitre,string $mailMessage, string $mailMessageHtml){
        
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mailAdmin)) // On filtre les serveurs qui rencontrent des bogues.
        {
            $passage_ligne = "\r\n";
        }
        else
        {
            $passage_ligne = "\n";
        }
        //=====Déclaration des messages au format texte et au format HTML.
        $message_txt = $mailMessage;
        $message_html = $mailMessageHtml;
        //==========

        //=====Création de la boundary
        $boundary = "-----=".md5(rand());
        //==========

        //=====Définition du sujet.
        $sujet = $mailTitre;
        //=========

        //=====Création du header de l'e-mail.
        $header = "From: \"wampkarl\"<wampkarl@gmail.com>".$passage_ligne;
        $header.= "Reply-to: \"wampkarl\" <wampkarl@gmail.com>".$passage_ligne;
        $header.= "MIME-Version: 1.0".$passage_ligne;
        $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
        //==========

        //=====Création du message.
        $message = $passage_ligne."--".$boundary.$passage_ligne;
        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_txt.$passage_ligne;
        //==========
        $message.= $passage_ligne."--".$boundary.$passage_ligne;
        //=====Ajout du message au format HTML
        $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
        $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
        $message.= $passage_ligne.$message_html.$passage_ligne;
        //==========
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
        //==========

        $socket = fsockopen('smtp.free.fr', '25');  
        if($socket)
        {
            //=====Envoi de l'e-mail.
            mail($mailAdmin,$sujet,$message,$header);
            //==========
        }else{
            echo 'le socket est fermé';
        }
    }
}//fin de classe
