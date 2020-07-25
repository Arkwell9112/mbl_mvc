<?php
require_once("/var/www/mbl/private/models/Model.php");
require_once("/var/www/mbl/private/models/MBLException.php");

class Connection extends Model
{
    const lifetime = 3 * 24 * 3600;

    private $username;
    private $token;
    private $date;

    public function __construct($username = null)
    {
        parent::__construct();
        $this->table = "connections";
        $this->primaries[] = "username";

        if (isset($username)) {
            $this->username = $username;
            $this->token = password_hash(random_int(PHP_INT_MIN, PHP_INT_MAX), PASSWORD_DEFAULT);
            $this->date = time();
        }

        $this->attributes["username"] = $this->username;
        $this->attributes["token"] = $this->token;
        $this->attributes["date"] = $this->date;
    }

    public static function createConnection(string $username, string $passwd): Connection
    {
        $bdd = Manager::getPDO();

        $statement = $bdd->prepare("SELECT * FROM users WHERE username=:username");
        $statement->execute(array(
            "username" => $username
        ));
        $user = $statement->fetchAll(PDO::FETCH_CLASS, "User");

        if (count($user) != 1) {
            throw new MBLException("badusername");
        }

        $user = $user[0];
        $hashword = $user->getAttributes()["hashword"];

        if (!password_verify($passwd, $hashword)) {
            throw new MBLException("badpasswd");
        }

        if ($user->getAttributes()["active"] != 1) {
            throw new MBLException("notactive");
        }

        $statement = $bdd->prepare("SELECT * FROM connections WHERE username=:username");
        $statement->execute(array(
            "username" => $username
        ));
        $connection = $statement->fetchAll(PDO::FETCH_CLASS, "Connection");

        if (count($connection) != 0) {
            $connection = $connection[0];
            $connection->delete();
        }

        $connection = new Connection($username);
        $connection->insert();

        setcookie("token", $connection->attributes["token"], time() + self::lifetime, "/", "monboulangerlivreur.fr", true, true);

        return $connection;
    }

    public static function retrieveConnection()
    {
        if (!isset($_COOKIE["token"])) {
            throw new MBLException("badtoken");
        }

        $bdd = Manager::getPDO();
        $statement = $bdd->prepare("SELECT * FROM connections WHERE token=:token");
        $statement->execute(array(
            "token" => $_COOKIE["token"]
        ));
        $connection = $statement->fetchAll(PDO::FETCH_CLASS, "Connection");

        if (count($connection) != 1) {
            throw new MBLException("badtoken");
        }

        $connection = $connection[0];
        $date = $connection->getAttributes()["date"];

        if (time() > $date + self::lifetime) {
            throw new MBLException("badtoken");
        }

        return $connection;
    }

    public function getUser(): User
    {
        $bdd = Manager::getPDO();
        $statement = $bdd->prepare("SELECT * FROM users WHERE username=:username");
        $statement->execute(array(
            "username" => $this->attributes["username"]
        ));
        $user = $statement->fetchAll(PDO::FETCH_CLASS, "User")[0];

        return $user;
    }
}