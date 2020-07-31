<?php
require_once("/var/www/mbl/private/models/Model.php");
require_once("/var/www/mbl/private/models/MBLException.php");
require_once("/var/www/mbl/private/models/Product.php");

class User extends Model
{
    private $username;
    private $hashword;
    private $mail;
    private $phone;
    private $address;
    private $city;
    private $geocode;
    private $active;
    private $vhash;
    private $pmethod;
    private $pok;
    private $date;
    private $value;
    private $command;

    public function __construct($username = null, $passwd = null, $mail = null, $phone = null, $address = null, $city = null, $geocode = null)
    {
        parent::__construct();
        $this->primaries[] = "username";
        $this->table = "users";

        if (isset($username)) {
            $this->username = $username;
            $this->hashword = password_hash($passwd, PASSWORD_DEFAULT);
            $this->mail = $mail;
            $this->phone = $phone;
            $this->address = $address;
            $this->city = $city;
            $this->geocode = $geocode;
            $this->active = 0;
            $this->vhash = password_hash(random_int(PHP_INT_MIN, PHP_INT_MAX), PASSWORD_DEFAULT);
            $this->pmethod = "";
            $this->pok = "0";
            $this->date = time();
            $this->value = 0;
            $this->command = "[]";
        }

        $this->attributes["username"] = $this->username;
        $this->attributes["hashword"] = $this->hashword;
        $this->attributes["mail"] = $this->mail;
        $this->attributes["phone"] = $this->phone;
        $this->attributes["address"] = $this->address;
        $this->attributes["city"] = $this->city;
        $this->attributes["geocode"] = $this->geocode;
        $this->attributes["active"] = $this->active;
        $this->attributes["vhash"] = $this->vhash;
        $this->attributes["pmethod"] = $this->pmethod;
        $this->attributes["pok"] = $this->pok;
        $this->attributes["date"] = $this->date;
        $this->attributes["value"] = $this->value;
        $this->attributes["command"] = $this->command;
    }

    public function insert()
    {
        parent::insert();

        $to = $this->attributes["mail"];
        $subject = "Vérification de votre compte MonBoulangerLivreur.fr";

        $headers = array();
        $headers["From"] = "MonBoulangerLivreur.fr <no-reply@monboulangerlivreur.fr>";
        $headers["Reply-To"] = "MonBoulangerLivreur.fr <contact@monboulangerlivreur.fr>";
        $headers["MIME-Version"] = "1.0";
        $headers["Content-type"] = "text/html; charset: utf8";

        $message = file_get_contents("/var/www/mbl/private/frags/fragMailRegister.html");
        $message = str_replace("+username+", $this->attributes["username"], $message);
        $message = str_replace("+token+", $this->attributes["vhash"], $message);
        $message = wordwrap($message, 70, "\r\n");

        mail($to, $subject, $message, $headers);
    }

    public function prepareReset()
    {
        $this->set("vhash", password_hash(random_int(PHP_INT_MIN, PHP_INT_MAX), PASSWORD_DEFAULT));

        $headers = array();
        $headers["MIME-Version"] = "1.0";
        $headers["Content-type"] = "text/html; charset=utf8";
        $headers["From"] = "MonBoulangerLivreur.fr <no-reply@monboulangerlivreur.fr>";
        $headers["Reply-To"] = "MonBoulangerLivreur.fr <contact@monboulangerlivreur.fr>";

        $to = $this->attributes["mail"];
        $subject = "Réinitialisation de votre mot de passe MonBoulangerLivreur.fr";

        $message = file_get_contents("/var/www/mbl/private/frags/fragMailReset.html");
        $message = str_replace("+username+", $this->attributes["username"], $message);
        $message = str_replace("+token+", $this->attributes["vhash"], $message);
        $message = wordwrap($message, 70, "\r\n");

        mail($to, $subject, $message, $headers);
    }

    public function activate()
    {
        $this->set("active", "1");
        $this->set("vhash", "");
    }

    public function reset(string $newpasswd)
    {
        $this->set("hashword", password_hash($newpasswd, PASSWORD_DEFAULT));
        $this->set("vhash", "");
    }

    public function getCommand(): array
    {
        return json_decode($this->attributes["command"], true);
    }

    public function getCity(): City
    {
        $bdd = Manager::getPDO();

        $statement = $bdd->prepare("SELECT * FROM cities WHERE name=:name");
        $statement->execute(array(
            "name" => $this->attributes["city"]
        ));

        return $statement->fetchAll(PDO::FETCH_CLASS, "City")[0];
    }

    public function setCommand(array $command)
    {
        $command = json_encode($command);
        $this->set("command", $command);
    }

    public function addProduct(string $name)
    {
        try {
            $product = Product::getProductByName($name);
            $deliveries = $this->getCity()->getDeliveries();
            $command = $this->getCommand();

            if (!isset($command[$name])) {
                $command[$name] = array();
                foreach ($deliveries as $key => $time) {
                    if ($time != 0) {
                        $command[$name][$key] = 0;
                    } else {
                        $command[$name][$key] = -1;
                    }
                }
                $this->setCommand($command);
            }
        } catch (MBLException $e) {

        }
    }
}