<?php

namespace Model\Market;

use Database\Database;
use Model\Exception\MarketException;
use Model\ModelInterface;
use PDO;

class ProductTypeTax implements ModelInterface
{

    protected $db;

    public $id;
    public $product_type_id;
    public $tax;
    public $created_at;
    public $productType;

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
                product_type_tax (product_type_id, tax, created_at)
            VALUES (:product_type_id, :tax, NOW())";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_type_id', $this->product_type_id);
        $stmt->bindParam(':tax', $this->tax);
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
                product_type_tax
            SET
                product_type_id = :product_type_id,
                tax = :tax
            WHERE
                id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':product_type_id', $this->product_type_id);
        $stmt->bindParam(':tax', $this->tax);
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

    public static function findCurrentTax($productTypeId = null)
    {
        $whereProductId = $productTypeId ? "AND product_type_id = :productTypeId" : '';
        $parameters = $productTypeId ? [':productTypeId' => $productTypeId] : [];

        $query =
            "WITH t AS (
                SELECT
                    product_type_tax.id,
                    product_type_tax.product_type_id,
                    product_type_tax.tax,
                    product_type_tax.created_at,
                    product_type.name product_type_name,
                    RANK () OVER (PARTITION BY product_type_id ORDER BY created_at DESC) rank_tax
                FROM
                    product_type_tax
                JOIN
                    product_type ON product_type.id = product_type_tax.product_type_id
                WHERE
                    created_at IS NOT NULL
                )
                SELECT
                    id,
                    product_type_id,
                    tax,
                    created_at,
                    product_type_name
                FROM
                    t
                WHERE
                    rank_tax = 1 $whereProductId
                ORDER BY product_type_name";

        $database = new Database();
        $db = $database->getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute($parameters);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function loadCurrentTax($productTypeId)
    {
        $taxes = ProductTypeTax::findCurrentTax($productTypeId);
        if (!$taxes || empty($taxes)) {
            return null;
        }
        $tax = $taxes[0];
        $taxModel = new ProductTypeTax((new Database())->getConnection());
        $taxModel->id = $tax['id'];
        $taxModel->product_type_id = $tax['product_type_id'];
        $taxModel->tax = $tax['tax'];
        $taxModel->created_at = $tax['created_at'];
        return $taxModel;
    }

    public static function where($where, $params = [])
    {
        // TODO: Implement where() method.
    }

    public function loadProductType()
    {
        $this->productType = ProductType::load($this->product_type_id);
    }

}
