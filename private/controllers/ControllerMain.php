<?php
require_once("/var/www/mbl/private/Manager.php");

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

    public static function actionPreRegister()
    {
        $error = "";

        if (isset($_POST["username"])) {
            if (!preg_match("#[A-Za-z0-9]{4,}#", $_POST["username"])) {
                $error = $error . "badusername";
            }
        } else {
            $error = $error . "badusername";
        }

        if (isset($_POST["passwd1"])) {
            if (!preg_match("#[A-Z]#", $_POST["passwd1"]) || !preg_match("#[a-z]#", $_POST["passwd1"]) || !preg_match("#[0-9]#", $_POST["passwd1"]) || !preg_match("#[^A-Za-z0-9]#", $_POST["passwd1"]) || !preg_match("#.{8,}#", $_POST["passwd1"])) {
                $error = $error . "badpasswd";
            }
        } else {
            $error = $error . "badpasswd";
        }

        if (isset($_POST["mail"])) {
            if (filter_var($_POST["mail"], FILTER_FLAG_EMAIL_UNICODE) != $_POST["mail"]) {
                $error = $error . "badmail";
            }
        } else {
            $error = $error . "badmail";
        }

        if (isset($_POST["phone"])) {
            if (!preg_match("#[0-9]{10}#", $_POST["phone"])) {
                $error = $error . "badphone";
            }
        } else {
            $error = $error . "badphone";
        }

        if (isset($_POST["passwd2"])) {
            if ($_POST["passwd1"] != $_POST["passwd2"]) {
                $error = $error . "diffpasswd";
            }
        } else {
            $error = $error . "diffpasswd";
        }

        if ($error == "") {
            $bdd = Manager::getPDO();

            $statement = $bdd->prepare("SELECT * FROM users WHERE username=:username");
            $statement->execute(array(
                "username" => $_POST["username"]
            ));

            $users = $statement->fetchAll();
            if (count($users) == 1) {
                $error = $error . "usernameexists";
            }
        }

        $username = $_POST["username"];
        $mail = $_POST["mail"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewRegister&status=$error&username=$username&mail=$mail&phone=$phone&address=$address");
    }
}