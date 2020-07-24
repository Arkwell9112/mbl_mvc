<?php


class Manager
{
    private static $pdo;
    private static $google;

    public static function getPDO(): PDO
    {
        if (!isset(self::$pdo)) {
            $config = array();
            exec("cat /var/mbl.conf", $config);
            $host = $config[2];
            $port = $config[3];
            $dbname = $config[4];
            self::$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $config[0], $config[1]);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }

    public static function getGoogleKey()
    {
        if (!isset(self::$google)) {
            $key = array();
            exec("cat /var/google.conf", $key);
            self::$google = $key[0];
        }

        return self::$google;
    }
}