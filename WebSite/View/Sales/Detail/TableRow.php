<?php

namespace View\Sales\Detail;

use Model\Market\ProductType;
use View\Selects\AvailableProductsForSale;
use View\View;

class TableRow implements View
{
    public function render($data = null): string
    {
        $data = $data ?? [
            'id' => '',
            'product_type_id' => 0,
            'sale_id' => '',
            'product_price_id' => '',
            'product_type_tax_id' => '',
            'amount' => '',
            'product_price' => 0,
            'product_type_tax' => 0,
        ];

        $productPriceId = $data['product_price_id'];
        $productTaxId = $data['product_type_tax_id'];
        $price = $data['product_price'] ? $data['product_price'] : 0;
        $tax = $data['product_type_tax'] ? $data['product_type_tax'] : 0;
        $taxValue = $price * $tax / 100;
        $total = $price + $taxValue;

        $selectAvailableProducts = new AvailableProductsForSale();
        $selectAvailableProducts->showLabel = false;
        $selectAvailableProducts->name = 'productId[]';

        $productType = ProductType::find($data['product_type_id']);
        if ($productType) {
            $productTypeName = $productType['name'];
        } else {
            $productTypeName = '';
        }

        return <<<HTML
            <tr dataset-id="{$data['id']}" dataset-sale-id="{$data['sale_id']}">
                <td>
                    {$selectAvailableProducts->render()}
                </td>
                <td>
                    <input type="text" value="{$productTypeName}" name="product_type[]" disabled>
                </td>
                <td>
                    <input type="number" value="{$data['amount']}" name="amount[]" step=0.01 min=0>
                </td>
                <td hidden>
                    <input type="hidden" value="{$productPriceId}" name="product_price_id[]" readonly>
                </td>
                <td hidden>
                    <input type="hidden" value="{$productTaxId}" name="product_type_tax_id[]" readonly>
                </td>
                <td>
                    <input type="number" value="{$price}" name="price[]"  disabled>
                </td>
                <td>
                    <input type="number" value="{$tax}" name="product_type_tax[]" disabled>
                </td>
                <td>
                    <input type="number" value="{$taxValue}" name="product_type_tax_value[]" disabled>
                </td>
                <td>
                    <input type="number" value="{$total}" name="total[]" disabled>
                </td>
            </tr>
HTML;
    }
}
