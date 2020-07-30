<?php
require_once("/var/www/mbl/private/Manager.php");
require_once("/var/www/mbl/private/models/User.php");
require_once("/var/www/mbl/private/models/Connection.php");
require_once("/var/www/mbl/private/models/City.php");

class ControllerAccount
{
    public static function viewAccount()
    {
        try {
            $connection = Connection::retrieveConnection();
            $user = $connection->getUser();

            $title = "Mon compte";
            $firstref = "https://monboulangerlivreur.fr/public/router.php";
            $firstfield = "Accueil";
            $secondref = "https://monboulangerlivreur.fr/public/router.php?request=actionDisconnect";
            $secondfield = "Se déconnecter";

            include("/var/www/mbl/private/views/account.php");
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }
}