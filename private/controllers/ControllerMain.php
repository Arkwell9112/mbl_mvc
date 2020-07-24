<?php
require_once("/var/www/mbl/private/Manager.php");
require_once("/var/www/mbl/private/models/User.php");

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

        if (isset($_GET["status"])) {
            $status = $_GET["status"];
        }

        $bdd = Manager::getPDO();

        $statement = $bdd->prepare("SELECT * FROM cities");
        $statement->execute();

        $cities = $statement->fetchAll();

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
            if (!(filter_var($_POST["mail"], FILTER_FLAG_EMAIL_UNICODE) != $_POST["mail"])) {
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

            $statement = $bdd->prepare("SELECT * FROM users WHERE mail=:mail");
            $statement->execute(array(
                "mail" => $_POST["mail"]
            ));

            $users = $statement->fetchAll();
            if (count($users) == 1) {
                $error = $error . "mailexists";
            }

            $statement = $bdd->prepare("SELECT * FROM users WHERE phone=:phone");
            $statement->execute(array(
                "phone" => $_POST["phone"]
            ));

            $users = $statement->fetchAll();
            if (count($users) == 1) {
                $error = $error . "phoneexists";
            }

            $statement = $bdd->prepare("SELECT * FROM cities WHERE name=:name");
            $statement->execute(array(
                "name" => $_POST["city"]
            ));

            $cities = $statement->fetchAll();
            if (count($cities) != 1) {
                $error = $error . "badcity";
            }
        }

        if ($error == "") {
            $address = $_POST["address"] . ", " . $_POST["city"] . ", " . "France";
            $address = urlencode($address);
            $key = Manager::getGoogleKey();
            $geo = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$key");
            $geo = json_decode($geo, true);
            if (isset($geo["status"])) {
                if ($geo["status"] == "OK") {
                    $address = $geo["results"][0]["formatted_address"];
                    $city = $_POST["city"];
                    if (preg_match("#$city#", $address)) {
                        session_start();
                        $_SESSION["username"] = $_POST["username"];
                        $_SESSION["passwd"] = $_POST["passwd1"];
                        $_SESSION["mail"] = $_POST["mail"];
                        $_SESSION["phone"] = $_POST["phone"];
                        $_SESSION["address"] = $address;
                        $_SESSION["city"] = $_POST["city"];
                        $_SESSION["geocode"] = $geo["results"][0]["geometry"]["location"]["lat"] . "," . $geo["results"][0]["geometry"]["location"]["lng"];
                        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewPostRegister");
                        ob_flush();
                        exit();
                    } else {
                        $error = $error . "badaddress";
                    }
                } else {
                    $error = $error . "special";
                }
            } else {
                $error = $error . "special";
            }
        }

        $username = $_POST["username"];
        $mail = $_POST["mail"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewRegister&status=$error&username=$username&mail=$mail&phone=$phone&address=$address");
    }

    public static function viewPostRegister()
    {
        session_start();

        if (isset($_SESSION["username"])) {

            $address = $_SESSION["address"];

            $firstref = "https://monboulangerlivreur.fr/public/router.php?request=viewMain";
            $firstfield = "Accueil";
            $secondref = "https://monboulangerlivreur.fr/public/router.php?request=viewSignin";
            $secondfield = "Se Connecter";

            include("/var/www/mbl/private/views/postregister.php");
        } else {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewRegister");
        }
    }

    public static function actionRegister()
    {
        if (isset($_POST["validation"])) {

            session_start();

            if ($_POST["validation"] == "yes") {
                $user = new User($_SESSION["username"], $_SESSION["passwd"], $_SESSION["mail"], $_SESSION["phone"], $_SESSION["address"], $_SESSION["city"], $_SESSION["geocode"]);
                $user->insert();
                session_unset();
                header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewRegister&status=yes");
            } else {
                $username = $_SESSION["username"];
                $mail = $_SESSION["mail"];
                $phone = $_SESSION["phone"];
                $address = $_SESSION["address"];
                session_unset();
                header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewRegister&username=$username&mail=$mail&phone=$phone&address=$address");
            }
        } else {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewRegister");
        }
    }
}