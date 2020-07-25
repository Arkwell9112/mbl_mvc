<?php
require_once("/var/www/mbl/private/models/Model.php");

class City extends Model
{
    private $name;
    private $deliveries;

    public function __construct(string $name = null)
    {
        parent::__construct();
        $this->table = "cities";
        $this->primaries[] = "name";

        if (isset($name)) {
            $this->name = $name;
            $this->deliveries = "[]";
        }

        $this->attributes["name"] = $this->name;
        $this->attributes["deliveries"] = $this->deliveries;
    }
}