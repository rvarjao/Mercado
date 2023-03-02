<?php

require_once __DIR__ . '/../../AutoLoad/AutoLoad.php';

use Database\Database;
use Model\Market\Product;
use Model\Market\Sale;

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {

    $db = Database::getInstance()->getConnection();
    $sale = new Sale($db);

    $sale->id = $_POST['id'] ?? null;

    $products = $_POST['productId'] ?? [];
    $amounts = $_POST['amount'] ?? [];

    try {

        $db->beginTransaction();

        $sale->save();

        foreach ($products as $key => $productId) {
            $product = Product::load($productId);

            if (!$product) {
                continue;
            }

            $amount = $amounts[$key];
            if ($amount <= 0) {
                echo json_encode(['success' => false, 'message' => 'Quantidade inválida']);
                exit;
            }

            $sale->addProduct($product, $amount);
        }

        $db->commit();
    } catch (\Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Venda salva com sucesso']);

}
