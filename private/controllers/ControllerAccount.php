<?php
require_once("/var/www/mbl/private/Manager.php");
require_once("/var/www/mbl/private/models/User.php");
require_once("/var/www/mbl/private/models/Connection.php");
require_once("/var/www/mbl/private/models/City.php");
require_once("/var/www/mbl/private/models/Product.php");
require_once("/var/www/mbl/private/vendor/autoload.php");

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

    public static function actionAddPayment()
    {
        try {
            $connection = Connection::retrieveConnection();
            $user = $connection->getUser();

            $stripe = new \Stripe\StripeClient(Manager::getStripeKey());

            if (isset($_POST["pm"])) {
                try {
                    $method = $stripe->paymentMethods->retrieve($_POST["pm"]);
                    if ($method->card["exp_year"] == date("Y") && $method->card["exp_month"] == date("m")) {
                        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=baddatecard");
                        ob_flush();
                        exit();
                    }
                    $setup = $stripe->setupIntents->create([
                        "confirm" => true,
                        "metadata" => [
                            "username" => $user->getAttributes()["username"]
                        ],
                        "payment_method" => $_POST["pm"],
                        "return_url" => "https://monboulangerlivreur.fr/public/router.php?request=actionRedirectIntent",
                        "usage" => "off_session"
                    ]);
                    if (isset($setup->next_action)) {
                        $url = $setup->next_action["redirect_to_url"]["url"];
                        header("Location: $url");
                    } else {
                        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=inprogress");
                    }
                } catch (Exception $e) {
                    header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=badcard");
                }
            }
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }

    public static function actionRedirectIntent()
    {
        if (isset($_GET["setup_intent"])) {
            $stripe = new \Stripe\StripeClient(Manager::getStripeKey());

            try {
                $intent = $stripe->setupIntents->retrieve($_GET["setup_intent"]);

                if (isset($intent->next_action)) {
                    $url = $setup->next_action["redirect_to_url"]["url"];
                    header("Location: $url");
                } else {
                    if ($intent->status == "succeeded") {
                        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=inprogress");
                    } else {
                        header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=badcard");
                    }
                }
            } catch (Exception $e) {
                header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=badcard");
            }
        } else {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount");
        }
    }

    public static function endpointSetupIntent()
    {
        \Stripe\Stripe::setApiKey(Manager::getStripeKey());

        $endpoint_secret = Manager::getStripeEndpoint(0);

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'setup_intent.succeeded':
                $intent = $event->data->object;

                $bdd = Manager::getPDO();
                $statement = $bdd->prepare("SELECT * FROM users WHERE username=:username");
                $statement->execute(array(
                    "username" => $intent->metadata["username"]
                ));
                $user = $statement->fetchAll(PDO::FETCH_CLASS, "User");

                if (count($user) == 1) {
                    $user = $user[0];
                    $user->set("pmethod", $intent->payment_method);
                    $user->set("pok", 1);
                }
                break;

            default:
                http_response_code(400);
                exit();
        }

        http_response_code(200);
    }

    public static function actionDeletePayment()
    {
        try {
            $connection = Connection::retrieveConnection();
            $user = $connection->getUser();

            if ($user->getAttributes()["value"] == 0 && date("G") >= 14) {
                $user->set("pok", 0);
                $user->set("pmethod", "");
                header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount");
            } else {
                header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewAccount&status=badcontextdel");
            }
        } catch (MBLException $e) {
            header("Location: https://monboulangerlivreur.fr/public/router.php?request=viewSignin");
        }
    }
}