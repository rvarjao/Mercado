<?php

require_once __DIR__ . '/../../AutoLoad/AutoLoad.php';

use Database\Database;
use Model\Market\ProductTypeTax;

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

    $db = Database::getInstance()->getConnection();
    $productTypeTax = new ProductTypeTax($db);
    $productTypeTax->tax = $_POST['tax'];
    $productTypeTax->product_type_id = $_POST['product_type_id'];

    try {
        $productTypeTax->save();
    } catch (\Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Produto salvo com sucesso']);

}
