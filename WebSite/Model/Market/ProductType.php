<?php

namespace Model\Market;

use Database\Database;
use Model\ModelInterface;
use PDO;

class ProductType implements ModelInterface
{

    protected $db;

    public $id;
    public $name;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save()
    {
        if (!isset($this->name) || empty($this->name)) {
            throw new \Exception("Name is required");
        }

        $params = [
            'name' => $this->name
        ];

        if (isset($this->id) && $this->id > 0) {
            $query = "UPDATE product_type SET name = :name WHERE id = :id";
            $params['id'] = $this->id;
        } else {
            $query = "INSERT INTO product_type (name) VALUES (:name) RETURNING id";
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        $this->id = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public function delete()
    {
    }

    public static function find($id)
    {
        $database = new Database();
        $connection = $database->getConnection();
        $query = "SELECT * FROM product_type WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findAll()
    {
        $database = new Database();
        $connection = $database->getConnection();
        $query = "SELECT * FROM product_type ORDER BY name";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
