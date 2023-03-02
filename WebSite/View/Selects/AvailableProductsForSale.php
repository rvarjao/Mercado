<?php

namespace View\Selects;

use Model\Market\Product;
use View\View;

class AvailableProductsForSale implements View
{
    public $showLabel = true;
    public $name = 'productId';
    public $value = null;

    public function render($data = null): string
    {

        $products = Product::findAvailableProductsForSale();

        $optionsProducts = "<option value=0>Selecione um produto</option>";

        foreach ($products as $product) {
            $selected = $this->value == $product['id'] ? 'selected' : '';
            $optionsProducts .= "<option value='{$product['id']}' $selected>{$product['name']}</option>";
        }

        if (!$this->showLabel) {
            return <<<HTML
            <select name="{$this->name}" >
                $optionsProducts
            </select>
HTML;
        }

        return <<<HTML
        <label for="{$this->name}">Produto
            <select name="{$this->name}" >
                $optionsProducts
            </select>
        </label>
HTML;
    }
}
