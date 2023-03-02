<?php

namespace View\Sales\Detail;

use Database\Database;
use Model\Market\SaleProduct;
use View\Selects\AvailableProductsForSale;
use View\View;

class TableRow implements View
{
    public function render($saleProduct = null): string
    {
        if (is_array($saleProduct)) {
            $saleProduct = new SaleProduct((new Database())->getConnection());
        } else {
            $saleProduct = $saleProduct ?? new SaleProduct((new Database())->getConnection());
        }

        $saleProduct->loadProductPrice();
        $saleProduct->loadProductTypeTax();

        $productPrice = $saleProduct->productPrice;
        $price = $productPrice ? $productPrice->price : 0;

        $productTypeTax = $saleProduct->productTypeTax;

        $tax = $productTypeTax ? $productTypeTax->tax : 0;

        $selectAvailableProducts = new AvailableProductsForSale();
        $selectAvailableProducts->showLabel = false;
        $selectAvailableProducts->name = 'productId[]';
        $selectAvailableProducts->value = $productPrice ? $productPrice->product_id : 0;

        $product = $productPrice->product ?? null;
        $productType = null;
        if ($product) {
            $product->loadProductType();
            $productType = $product->productType;
        }

        if ($productType) {
            $productTypeName = $productType->name;
        } else {
            $productTypeName = '';
        }

        $saleId = $saleProduct->sale_id ?? null;
        $amount = $saleProduct->amount ?? 0;
        $productPriceId = $saleProduct->product_price_id ?? null;
        $productTypeTaxId = $saleProduct->product_type_tax_id ?? null;
        $productId = $product->id ?? null;


        return <<<HTML
            <tr data-id="{$productId}" data-sale-id="{$saleId}">
                <td>
                    {$selectAvailableProducts->render()}
                </td>
                <td>
                    <input type="text" value="{$productTypeName}" name="product_type[]" disabled>
                </td>
                <td>
                    <input type="number" value="{$amount}" name="amount[]" step=0.01 min=0>
                </td>
                <td hidden>
                    <input type="hidden" value="{$productPriceId}" name="product_price_id[]" readonly>
                </td>
                <td hidden>
                    <input type="hidden" value="{$productTypeTaxId}" name="product_type_tax_id[]" readonly>
                </td>
                <td>
                    <input type="number" value="{$price}" name="price[]"  disabled>
                </td>
                <td>
                    <input type="number" value="{$tax}" name="product_type_tax[]" disabled>
                </td>
                <td>
                    <input type="number" value="0" name="product_type_tax_value[]" disabled>
                </td>
                <td>
                    <input type="number" value="0" name="total[]" disabled>
                </td>
            </tr>
HTML;
    }
}
