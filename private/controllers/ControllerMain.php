<?php


class ControllerMain
{
    public static function viewMain()
    {
        $title = "Accueil";
        $firstref = "#";
        $firstfield = "S'inscrire";
        $secondref = "#";
        $secondfield = "Se Connecter";
        include("/var/www/mbl/private/views/main.php");
    }
}