<?php

require_once __DIR__ . '/../../AutoLoad/AutoLoad.php';

use Database\Database;
use Model\Market\ProductType;

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $name = $_POST['name'];
    $db = Database::getInstance()->getConnection();
    $productType = new ProductType($db);
    $productType->name = $name;
    try {
        $productType->save();
    } catch (\Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Produto salvo com sucesso']);

}
