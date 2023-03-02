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
		$salesProducts = $sale->products ?? [];

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
			</table>
		</figure>
		<div class="container">
			<table>
				<tbody>
					<tr>
						<th style="text-align:right;">
							Produtos (R$)
						</th>
						<td width=25%>
							<input type="number" value="0" name="saleTotal" id="saleTotalProducts" disabled/>
						</td>
						<td width=25%></td>
					</tr>
					<tr>
						<th style="text-align:right;">
							Imposto (R$)
						</th>
						<td width=25%>
							<input type="number" value="0" name="saleTotal" id="saleTotalTax" disabled/>
						</td>
						<td width=25%></td>
					</tr>
					<tr>
						<th style="text-align:right;">
							Total (R$)
						</th>
						<td width=25%>
							<input type="number" value="0" name="saleTotal" id="saleTotal" disabled style="font-weight:bold;" />
						</td>
						<td width=25%></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	<footer>
		<div class="grid">
			<a href=# role="button" onclick="SaleView.addRow(event)" class="contrast outline">
				<i class="fa-solid fa-plus"></i><span style="margin-left:0.5rem;">Adicionar produto</span></a>
			<a href=# role="button" onclick="SaleView.save(event)">
				<i class="fa-solid fa-floppy-disk"></i><span style="margin-left:0.5rem;">Salvar venda</span></a>
		</div>
	</footer>

HTML;
	}
}
