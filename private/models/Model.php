<?php
require_once("/var/www/mbl/private/Manager.php");

class Model
{
    protected $attributes;
    protected $primaries;
    protected $table;

    public function __construct()
    {
        $this->attributes = array();
        $this->primaries = array();
    }

    protected function createPrimaryString(): string
    {
        $primarystring = " WHERE";

        for ($i = 0; $i <= count($this->primaries) - 1; $i++) {
            $primary = $this->primaries[$i];
            $primarystring = $primarystring . " $primary=:$primary";

            if ($i != count($this->primaries) - 1) {
                $primarystring = $primarystring . " AND";
            }
        }

        return $primarystring;
    }

    public function insert()
    {
        $table = $this->table;

        $namestring = "";
        $valuestring = "";
        $i = 0;

        foreach ($this->attributes as $key => $attribute) {
            $namestring = $namestring . $key;

            $valuestring = $valuestring . ":$key";

            if ($i != count($this->attributes) - 1) {
                $namestring = $namestring . ",";
                $valuestring = $valuestring . ",";
            }

            $i++;
        }

        $sql = "INSERT INTO $table ($namestring) VALUES ($valuestring)";
        $bdd = Manager::getPDO();
        $statement = $bdd->prepare($sql);
        $statement->execute($this->attributes);
    }

    public function delete()
    {
        $table = $this->table;

        $sql = "DELETE FROM $table";
        $sql = $sql . $this->createPrimaryString();
        $bdd = Manager::getPDO();
        $statement = $bdd->prepare($sql);
        $statement->execute($this->attributes);
    }

    public function update()
    {
        $table = $this->table;

        $sql = "SELECT * FROM $table";
        $sql = $sql . $this->createPrimaryString();
        $bdd = Manager::getPDO();
        $statement = $bdd->prepare($sql);
        $statement->execute($this->attributes);

        $result = $statement->fetchAll()[0];

        foreach ($this->attributes as $key => $attribute) {
            $this->attributes[$key] = $result[$key];
        }
    }

    public function set(string $column, string $value)
    {
        $table = $this->table;

        $sql = "UPDATE $table SET $column=:$column";
        $sql = $sql . $this->createPrimaryString();
        $bdd = Manager::getPDO();
        $statement = $bdd->prepare($sql);

        $newattributes = $this->attributes;
        $newattributes[$column] = $value;

        $statement->execute($newattributes);

        $this->update();
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}