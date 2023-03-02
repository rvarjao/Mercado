<?php

namespace Model\Market;

use Database\Database;
use Exception;
use Model\Exception\MarketException;
use Model\ModelInterface;
use PDO;

class SaleProduct implements ModelInterface
{
    public $id;
    public $product_type_tax_id;
    public $sale_id;
    public $product_price_id;
    public $amount;
    public $productPrice;
    public $productTypeTax;
    protected $db;

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

    public function update()
    {
        if (!$this->id) {
            throw new MarketException('Não é possível atualizar um produto sem ID');
        }

        $connection = $this->db;
        $query =
            "UPDATE
                sale_product
            SET
                product_type_tax_id = :product_type_tax_id,
                sale_id = :sale_id,
                product_price_id = :product_price_id,
                amount = :amount
            WHERE
                id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_type_tax_id', $this->product_type_tax_id);
        $stmt->bindParam(':sale_id', $this->sale_id);
        $stmt->bindParam(':product_price_id', $this->product_price_id);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $connection = $this->db;
        $query =
            "INSERT INTO
                sale_product (product_type_tax_id, sale_id, product_price_id, amount)
            VALUES (:product_type_tax_id, :sale_id, :product_price_id, :amount)
            RETURNING id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_type_tax_id', $this->product_type_tax_id);
        $stmt->bindParam(':sale_id', $this->sale_id);
        $stmt->bindParam(':product_price_id', $this->product_price_id);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->execute();
        return $stmt;
    }

    public function delete()
    {
        throw new MarketException('Not implemented');
    }

    public static function find($id)
    {
        throw new MarketException('Not implemented');
    }

    public static function findAll()
    {
        throw new MarketException('Not implemented');
    }

    public static function where($where, $params = [])
    {
        throw new MarketException('Not implemented');
    }

    public function loadProductPrice()
    {
        $connection = $this->db;
        $query =
            "SELECT
                product_price.id,
                product_price.product_id,
                product_price.price,
                product_price.created_at
            FROM
                product_price
            WHERE
                product_price.id = :product_price_id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_price_id', $this->product_price_id);
        $stmt->execute();
        $productPrice = $stmt->fetchObject('Model\Market\ProductPrice', [$connection]);
        if ($productPrice) {
            $this->productPrice = $productPrice->loadProduct();
        }
        return $productPrice;
    }

    public function loadProductTypeTax()
    {
        $connection = $this->db;
        $query =
            "SELECT
                product_type_tax.id,
                product_type_tax.product_type_id,
                product_type_tax.tax,
                product_type_tax.created_at
            FROM
                product_type_tax
            WHERE
                product_type_tax.id = :product_type_tax_id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_type_tax_id', $this->product_type_tax_id);
        $stmt->execute();
        $productTypeTax = $stmt->fetchObject('Model\Market\ProductTypeTax', [$connection]);
        if ($productTypeTax) {
            $productTypeTax->loadProductType();
        }
        $this->productTypeTax = $productTypeTax;
        return $productTypeTax;
    }

}
