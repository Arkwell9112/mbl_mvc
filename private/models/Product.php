<?php
require_once("/var/www/mbl/private/models/Model.php");
require_once("/var/www/mbl/private/models/MBLException.php");

class Product extends Model
{
    private $name;
    private $price;

    public function __construct($name = null, $price = null)
    {
        parent::__construct();

        $this->table = "products";
        $this->primaries[] = "name";

        if (isset($name)) {
            $this->name = $name;
            $this->price = $price;
        }

        $this->attributes["name"] = $this->name;
        $this->attributes["price"] = $this->price;
    }

    public static function getProducts(): array
    {
        $bdd = Manager::getPDO();

        $statement = $bdd->prepare("SELECT * FROM products");
        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_CLASS, "Product");

        return $products;
    }

    public static function getProductByName(string $name): Product
    {
        $bdd = Manager::getPDO();

        $statement = $bdd->prepare("SELECT * FROM products WHERE name=:name");
        $statement->execute(array(
            "name" => $name
        ));
        $products = $statement->fetchAll(PDO::FETCH_CLASS, "Product");

        if (count($products) == 1) {
            return $products[0];
        } else {
            throw new MBLException("badname");
        }
    }
}