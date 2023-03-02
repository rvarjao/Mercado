<?php

require_once __DIR__ . '/../../AutoLoad/AutoLoad.php';

use Database\Database;
use Model\Market\Product;

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $name = $_POST['name'];
    $db = Database::getInstance()->getConnection();
    $product = new Product($db);
    $product->name = $name;
    $product->product_type_id = $_POST['product_type_id'];

    try {
        $product->save();
    } catch (\Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Produto salvo com sucesso']);

}

if ($method == 'GET') {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID não informado']);
        exit;
    }

    $product = Product::load($id);
    $product->loadProductPrice();
    $product->loadProductTypeTax();
    $product->loadProductType();

    echo json_encode($product);
}
