<?php

require_once __DIR__ . '/../../AutoLoad/AutoLoad.php';

use Database\Database;
use Model\Market\ProductPrice;

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

    $db = Database::getInstance()->getConnection();
    $price = new ProductPrice($db);
    $price->price = $_POST['price'];
    $price->product_id = $_POST['product_id'];

    try {
        $price->save();
    } catch (\Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Produto salvo com sucesso']);

}
