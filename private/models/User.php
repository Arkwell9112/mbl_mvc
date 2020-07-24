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
        }

        $this->attributes["username"] = $this->username;
        $this->attributes["hashword"] = $this->hashword;
        $this->attributes["mail"] = $this->mail;
        $this->attributes["phone"] = $this->phone;
        $this->attributes["address"] = $this->address;
        $this->attributes["city"] = $this->city;
        $this->attributes["geocode"] = $this->geocode;
    }
}