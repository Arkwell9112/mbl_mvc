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

            $productsobject = Product::getProducts();
            $products = "";

            foreach ($productsobject as $product) {
                $name = $product->getAttributes()["name"];
                $price = number_format($product->getAttributes()["price"], 2);
                $products = $products . "<option value='$name'>$name - $price €</option>";
            }

            $products = "<select class='productselect' id='productselect'>
                       <option value='none'>Sélectionnez un produit à ajouter</option>
                       $products
                       </select><br><br>
                       <span class='editbutton addvalidatebutton'>Valider</span>";

            include("/var/www/mbl/private/views/account.php");
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }
}