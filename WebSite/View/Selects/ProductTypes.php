<?php

namespace View\Selects;

use Model\Market\ProductType;
use View\View;

class ProductTypes implements View
{
    public function render($data = null): string
    {
        $productTypes = ProductType::findAll();
        $optionsProducts = "<option>Selecione um tipo de produto</option>";
        foreach ($productTypes as $productType) {
            $optionsProducts .= "<option value='{$productType['id']}'>{$productType['name']}</option>";
        }

        return <<<HTML
        <label for="productTypeId">Tipo do produto
            <select name="productTypeId" >
                $optionsProducts
            </select>
        </label>
HTML;
    }
}
