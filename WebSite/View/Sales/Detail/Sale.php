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

		$sale->loadProducts();
		$salesProducts = $sale->products;

		$trs = "";
		foreach ($salesProducts as $saleProduct) {
			$tableRow = new TableRow();
			$trs .= $tableRow->render($saleProduct);
		}


		return <<<HTML
	<h1>Venda</h1>
	<form id="formSale">
		<input type="hidden" name="id" value="{$saleId}"/>
		<figure>
			<table id="tableSaleProducts" role="grid" style="min-width:70rem;">
				<thead>
					<tr>
						<th hidden>ID</th>
						<th>Produto</th>
						<th>Tipo</th>
						<th>Quantidade</th>
						<th>Valor unitário (R$)</th>
						<th>Imposto (%)</th>
						<th>Imposto (R$)</th>
						<th>Total</th>
					</tr>
				</thead>
					<tbody id="tbody">
						$trs
					</tbody>
				<tfoot>
					<tr>
						<td colspan="5"></td>
						<td>Total</td>
						<td>
							<input type="number" value="0" name="saleTotal" id="saleTotal" disabled/>
						</td>
					</tr>
				</tfoot>
			</table>
		</figure>
	</form>
	<footer>
		<div class="grid">
			<a href=# role="button" onclick="SaleView.addRow(event)" class="contrast outline">Adicionar produto</a>
			<a href=# role="button" onclick="SaleView.save(event)">Salvar venda</a>
		</div>
	</footer>

HTML;
	}
}
