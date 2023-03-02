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
                sale (created_at)
                VALUES (?)";

        $stmt = $connection->prepare($query);
        $createdAt = $this->createdAt ? $this->createdAt : date('Y-m-d H:i:s O');
        $stmt->execute([$createdAt]);
        $this->id = $connection->lastInsertId();
        $this->createdAt = $createdAt;
        return $stmt;
    }

    public function update()
    {
        if (!$this->id) {
            throw new MarketException("Id da venda não encontrado.", 1);
        }

        $connection = $this->db;
        $query =
            "UPDATE
                sale
            SET
                created_at = :created_at
            WHERE
                id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':created_at', $this->createdAt);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
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
        $where = $id ? "WHERE s.id = :id" : "";

        $query =
            "SELECT
            s.id,
            s.created_at,
            sum(pp.price * amount + (ptt.tax / 100) * pp.price * amount) AS total
        FROM
            sale s
        LEFT JOIN
            sale_product sp ON sp.sale_id = s.id
        LEFT JOIN
            product_price pp ON pp.id = sp.product_price_id
        LEFT JOIN
            product_type_tax ptt ON ptt.id = sp.product_type_tax_id
        $where
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

    public function findProducts()
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

    public function addProduct(Product $product, $amount = 1)
    {
        if (!$this->id) {
            $this->save();
        }

        $productPrice = ProductPrice::loadCurrentPrice($product->id);
        $productTypeTax = ProductTypeTax::loadCurrentTax($product->product_type_id);

        $saleProduct = new SaleProduct($this->db);
        $saleProduct->product_price_id = $productPrice->id;

        if ($productTypeTax) {
            $saleProduct->product_type_tax_id = $productTypeTax->id;
        }

        $saleProduct->sale_id = $this->id;
        $saleProduct->amount = $amount;
        $saleProduct->save();
    }

}
