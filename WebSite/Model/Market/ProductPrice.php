<?php

namespace Model\Market;

use Database\Database;
use Model\Exception\MarketException;
use Model\ModelInterface;
use PDO;

class ProductPrice implements ModelInterface
{

    protected $db;

    public $id;
    public $product_id;
    public $price;
    public $created_at;

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
                product_price (product_id, price, created_at)
            VALUES (:product_id, :price, NOW())";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':price', $this->price);
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
                product_price
            SET
                product_id = :product_id,
                price = :price
            WHERE
                id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public static function find($id)
    {
        // TODO: Implement find() method.
    }

    public static function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public static function findCurrentPrice($id = null)
    {
        $whereProductId = $id ? "AND product_id = :product_id" : '';
        $parameters = $id ? ["product_id" => $id] : [];

        $query =
            "WITH t AS (
                SELECT
                    product_price.id,
                    product_price.product_id,
                    product_price.price,
                    product_price.created_at,
                    product.name as product_name,
                    product_type.name product_type_name,
                    RANK () OVER (PARTITION BY product_id ORDER BY created_at DESC) rank_price
                FROM
                    product_price
                JOIN
                    product ON product.id = product_price.product_id
                JOIN
                    product_type ON product_type.id = product.product_type_id
                WHERE
                    created_at IS NOT NULL
                ORDER BY
                    product_id
                )
                SELECT
                    id,
                    product_id,
                    price,
                    created_at,
                    product_type_name,
                    product_name
                FROM
                    t
                WHERE
                    rank_price = 1 $whereProductId";

        $database = new Database();
        $db = $database->getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function where($where, $params = [])
    {
        // TODO: Implement where() method.
    }

    public static function loadCurrentPrice($productId)
    {
        $price = ProductPrice::findCurrentPrice($productId);
        if (!$price || empty($price)) {
            return null;
        }
        $price = $price[0];
        $priceModel = new ProductPrice((new Database())->getConnection());
        $priceModel->id = $price['id'];
        $priceModel->product_id = $price['product_id'];
        $priceModel->price = $price['price'];
        $priceModel->created_at = $price['created_at'];
        return $priceModel;
    }

}
