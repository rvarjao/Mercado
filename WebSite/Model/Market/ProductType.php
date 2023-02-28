<?php

namespace Model\Market;

use Model\ModelInterface;
use PDO;

class ProductType implements ModelInterface {

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save() {

    }

    public function delete() {

    }

    public static function find($id) {

    }

    public static function findAll() {

    }

}
