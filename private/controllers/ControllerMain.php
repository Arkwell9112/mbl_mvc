<?php


class ControllerMain
{
    public static function viewMain()
    {
        $title = "Accueil";
        $firstref = "https://monboulangerlivreur.fr/public/router.php?request=viewRegister";
        $firstfield = "S'inscrire";
        $secondref = "https://monboulangerlivreur.fr/public/router.php?request=viewSignin";
        $secondfield = "Se Connecter";
        include("/var/www/mbl/private/views/main.php");
    }

    public static function viewRegister()
    {
        $title = "Inscription";
        $firstref = "https://monboulangerlivreur.fr/public/router.php";
        $firstfield = "Accueil";
        $secondref = "https://monboulangerlivreur.fr/public/router.php?request=viewSignin";
        $secondfield = "Se Connecter";
        include("/var/www/mbl/private/views/register.php");
    }

    public static function viewSignin()
    {
        $title = "Connexion";
        $firstref = "https://monboulangerlivreur.fr/public/router.php";
        $firstfield = "Accueil";
        $secondref = "https://monboulangerlivreur.fr/public/router.php?request=viewRegister";
        $secondfield = "S'inscrire";
        include("/var/www/mbl/private/views/signin.php");
    }
}