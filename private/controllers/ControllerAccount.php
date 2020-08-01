<?php
require_once("/var/www/mbl/private/Manager.php");
require_once("/var/www/mbl/private/models/User.php");
require_once("/var/www/mbl/private/models/Connection.php");
require_once("/var/www/mbl/private/models/City.php");
require_once("/var/www/mbl/private/models/Product.php");

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

            if (isset($_GET["status"])) {
                $status = $_GET["status"];
            } else {
                $status = "";
            }

            $productsobject = Product::getProducts();
            $products = "";

            foreach ($productsobject as $product) {
                $name = $product->getAttributes()["name"];
                $price = number_format($product->getAttributes()["price"], 2);
                $products = $products . "<option value='$name'>$name - $price €</option>";
            }

            $products = "<select class='productselect'>
                       <option value='none'>Sélectionnez un produit à ajouter</option>
                       $products
                       </select><br><br>
                       <span class='editbutton addvalidatebutton'>Valider</span>";

            include("/var/www/mbl/private/views/account.php");
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }

    public static function actionAddProduct()
    {
        try {
            $connection = Connection::retrieveConnection();
            $user = $connection->getUser();

            if (isset($_GET["name"])) {
                $user->addProduct($_GET["name"]);
            }
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount");
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }

    public static function actionDeleteProduct()
    {
        try {
            $connection = Connection::retrieveConnection();
            $user = $connection->getUser();

            if (isset($_GET["name"])) {
                try {
                    $user->deleteProduct($_GET["name"], true);
                    header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount");
                } catch (MBLException $e) {
                    $status = $e->getMessage();
                    header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=$status");
                }
            }
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }

    public static function actionDisconnect()
    {
        try {
            $connection = Connection::retrieveConnection();
            $connection->delete();
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewMain");
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }

    public static function actionEditProduct()
    {
        try {
            $connection = Connection::retrieveConnection();
            $user = $connection->getUser();

            if (isset($_GET["name"]) && isset($_GET["table"])) {
                $table = json_decode($_GET["table"], true);

                if (isset($table)) {
                    if (count($table) == 7) {
                        try {
                            $user->editProduct($_GET["name"], $table);
                            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount");
                        } catch (MBLException $e) {
                            $status = $e->getMessage();
                            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=$status");
                        }
                    } else {
                        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount");
                    }
                } else {
                    header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount");
                }
            }
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }
}