<?php

namespace View\Sales\Detail;

use Database\Database;
use Model\Market\Sale as MarketSale;
use View\View;

class Sale implements View
{
    public function render($data = null): string
    {
        $db = new Database();
        $connection = $db->getConnection();
		$saleId = $data['id'] ?? $data['sale_id'] ?? null;
        if ($saleId) {
            $sale = MarketSale::find($saleId);
        } else {
            $sale = new MarketSale($connection);
        }

		$salesProducts = $sale->getSaleItems();
		$trs = "";


        return <<<HTML
	<h1>Venda</h1>
	<table>
		<thead>
			<tr>
				<th hidden>ID</th>
				<th>Product</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Tax (%)</th>
				<th>Tax ($)</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody id="tbody">
			$trs
		</tbody>
	</table><br>
	<button onclick="SaleView.addRow(event)">Add Row</button>
HTML;
    }
}
