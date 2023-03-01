<?php

namespace Model\Market;

use Database\Database;
use Model\Exception\MarketException;
use Model\ModelInterface;
use PDO;

class Product implements ModelInterface
{

    protected $db;
    public $id;
    public $name;
    public $product_type_id;
    public $productPrice;
    public $productTypeTax;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save()
    {
        if ($this->id) {
            return $this->update();
        }
        return $this->create();
    }

    public function create()
    {
        $connection = $this->db;
        $query =
            "INSERT INTO
                product (name, product_type_id)
            VALUES (:name, :product_type_id)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':product_type_id', $this->product_type_id);
        $stmt->execute();
        return $stmt;
    }

    public function update()
    {
        if (!$this->id) {
            throw new MarketException('Não é possível atualizar um produto sem ID');
        }

        $connection = $this->db;
        $query =
            "UPDATE
                product
            SET
                name = :name,
                product_type_id = :product_type_id
            WHERE
                id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':product_type_id', $this->product_type_id);
        $stmt->execute();
        return $stmt;
    }

    public function delete()
    {
    }

    public static function find($id)
    {
        $product = Product::where('product.id = :id', [':id' => $id]);
        return $product[0];
    }

    public static function load($id)
    {
        $product = Product::find($id);
        $database = new Database();
        $connection = $database->getConnection();
        $productModel = new Product($connection);
        $productModel->id = $product['id'];
        $productModel->name = $product['name'];
        $productModel->product_type_id = $product['product_type_id'];
        return $productModel;
    }

    public static function findAll()
    {
        $database = new Database();
        $connection = $database->getConnection();
        $query =
            "SELECT
                product.id,
                product.name,
                product.product_type_id,
                product_type.name AS product_type_name
            FROM
                product
            JOIN
                product_type ON product_type.id = product.product_type_id
            ORDER BY product.name";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function where($where, $params = [])
    {
        $database = new Database();
        $connection = $database->getConnection();
        $where = $where ? "WHERE $where" : "";

        $query =
            "SELECT
                product.id,
                product.name,
                product.product_type_id,
                product_type.name AS product_type_name
            FROM
                product
            JOIN
                product_type ON product_type.id = product.product_type_id
            $where
            ORDER BY product.name";
        $stmt = $connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findAvailableProductsForSale($id = null)
    {
        $database = new Database();
        $connection = $database->getConnection();
        $whereID = $id ? " AND product.id = $id" : "";

        $query =
            "SELECT
                product.id,
                product.name,
                product.product_type_id,
                product_type.name AS product_type_name
            FROM
                product
            JOIN
                product_type ON product_type.id = product.product_type_id
            WHERE EXISTS
                (SELECT
                    1
                FROM
                    product_price
                WHERE
                    product_price.product_id = product.id
                AND
                    product_price.price > 0)
            $whereID
            ORDER BY product.name";

        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function loadProductPrice()
    {
        $productId = $this->id;
        $this->productPrice = ProductPrice::loadCurrentPrice($productId);
    }

    public function loadProductTypeTax()
    {
        $this->productTypeTax = ProductTypeTax::loadCurrentTax($this->product_type_id);
    }

}
