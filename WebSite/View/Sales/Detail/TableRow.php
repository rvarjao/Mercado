<?php

namespace View\Sales\Detail;

use View\Selects\AvailableProductsForSale;
use View\View;

class TableRow implements View
{
    public function render($data = null): string
    {
        $data = $data ?? [
            'id' => '',
            'product_type_tax_id' => '',
            'sale_id' => '',
            'product_price_id' => '',
            'amount' => '',
        ];

        $selectAvailableProducts = new AvailableProductsForSale();

        return <<<HTML
            <tr dataset-id="{$data['id']}">
                <td>{$data['product_']}</td>
                <td>{$data['product_price_id']}</td>
                <td>{$data['product_type_tax_id']}</td>
                <td>{$data['sale_id']}</td>
                <td>{$data['product_price_id']}</td>
                <td>{$data['amount']}</td>
            </tr>
HTML;
    }
}
