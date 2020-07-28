<?php
require_once("/var/www/mbl/private/models/Model.php");

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
}