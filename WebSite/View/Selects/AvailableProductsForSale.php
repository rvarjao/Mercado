<?php

namespace View\Selects;

use Model\Market\Product;
use View\View;

class AvailableProductsForSale implements View
{
    public function render($data = null): string
    {
        $products = Product::findAvailableProductsForSale();
        $optionsProducts = "<option>Selecione um produto</option>";
        foreach ($products as $product) {
            $optionsProducts .= "<option value='{$product['id']}'>{$product['name']}</option>";
        }

        return <<<HTML
        <label for="productId">Produto
            <select name="productId" >
                $optionsProducts
            </select>
        </label>
HTML;
    }
}
