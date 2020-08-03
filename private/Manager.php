<?php


class Manager
{
    private static $pdo;
    private static $google;
    private static $stripe;

    public static function getPDO(): PDO
    {
        if (!isset(self::$pdo)) {
            $config = array();
            exec("cat /etc/mbl.creds", $config);
            $host = $config[2];
            $port = $config[3];
            $dbname = $config[4];
            self::$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $config[0], $config[1]);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }

    public static function getGoogleKey(): string
    {
        if (!isset(self::$google)) {
            $key = array();
            exec("cat /etc/mbl.creds", $key);
            self::$google = $key[5];
        }

        return self::$google;
    }

    public static function getDay(): int
    {
        $day = date("w");
        $day--;
        if ($day < 0) {
            $day = 6;
        }
        return $day;
    }

    public static function getStripeKey(): string
    {
        if (!isset(self::$stripe)) {
            $key = array();
            exec("cat /etc/mbl.creds", $key);
            self::$stripe = $key[6];
        }

        return self::$stripe;
    }

    public static function getStripeEndpoint(int $i): string
    {
        $endpoint = array();
        exec("cat /etc/mbl.creds", $endpoint);
        return $endpoint[7 + $i];
    }
}