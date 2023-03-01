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
		foreach ($salesProducts as $saleProduct) {
			$tableRow = new TableRow($saleProduct);
			$trs .= $tableRow->render();
		}


        return <<<HTML
	<h1>Venda</h1>
	<figure>
		<table id="tableSaleProducts" role="grid" style="min-width:70rem;">
			<thead>
				<tr>
					<th hidden>ID</th>
					<th>Produto</th>
					<th>Quantidade</th>
					<th>Valor unitário (R$)</th>
					<th>Imposto (%)</th>
					<th>Imposto (R$)</th>
					<th>Total</th>
				</tr>
			</thead>
			<form id="formSaleProducts">
				<tbody id="tbody">
					$trs
				</tbody>
			</form>
			<tfoot>
				<tr>
					<td colspan="5">Total</td>
					<td>
						<input type="number" value="0" name="saleTotal" id="saleTotal" disabled/>
					</td>
				</tr>
			</tfoot>
		</table>
	</figure>
	<br>
	<button onclick="SaleView.addRow(event)">Adicionar produto</button>
HTML;
    }
}
