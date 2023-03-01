<?php

namespace View\Sales;

use Model\Market\Sale;
use View\View;

class Index implements View
{
    public function render($data = null): string
    {

        $sales = Sale::findSummary();
        $trs = "";
        foreach ($sales as $sale) {
            $tr = new TableRow();
            $trs .= $tr->render($sale);
        }

        return <<<HTML

<section>
    <h1>Vendas</h1>
    <a href=#
        data-target="modal-newProduct"
        role="button"
        onclick="SaleView.loadNewSaleView()">Nova venda</a>
    <table id="sales" role="grid">
        <thead>
            <tr>
                <th hidden>Id</th>
                <th>Data/Hora</th>
                <th>Valor total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            $trs
        </tbody>
    </table>
</section>

HTML;
    }
}
