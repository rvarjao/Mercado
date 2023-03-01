<?php

namespace Model\Market;

use Database\Database;
use Model\Exception\MarketException;
use Model\ModelInterface;
use PDO;

class Sale implements ModelInterface
{

    protected $db;

    public $id;
    public $createdAt;


    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save()
    {
        throw new MarketException("Not implemented yet", 1);
    }

    public function delete()
    {
        throw new MarketException("Not implemented yet", 1);
    }

    public static function find($id)
    {
        throw new MarketException("Not implemented yet", 1);
    }

    public static function findAll()
    {
        throw new MarketException("Not implemented yet", 1);
    }

    public static function findSummary($id = null)
    {
        $query =
            "SELECT
            s.id,
            s.created_at,
            sum(pp.price) AS total
        FROM
            sale s
        LEFT JOIN
            sale_product sp ON sp.sale_id = s.id
        LEFT JOIN
            product_price pp ON pp.id = sp.product_price_id
        GROUP BY
            s.id,
            s.created_at";

        $db = new Database();
        $connection = $db->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function where($where, $params = [])
    {
        throw new MarketException("Not implemented yet", 1);
    }

    public function getSaleItems()
    {
        if (!$this->id) {
            return [];
        }

        $query =
        "SELECT
            *
        FROM
            sale_product
        JOIN
            product_price ON product_price.id = sale_product.product_price_id
        JOIN
            product ON product.id = product_price.product_id
        JOIN
            product_type ON product_type.id = product.product_type_id
        JOIN
            product_tax ON product_tax.id = product_price.product_tax_id
        WHERE
            sale_product.sale_id = :sale_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sale_id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll();

    }

}
