<?php

namespace View\Sales;

use View\View;

class Index implements View
{
    public function render($data = null): string
    {
        $data = $data ?? [];
        $trs = "";
        foreach ($data as $product) {
            $tr = new TableRow();
            $trs .= $tr->render($product);
        }

        $optionsProducts = "";
        $optionsProducts .= "<option value=''>Selecione</option>";
        $optionsProducts .= "<option value='1'>Produto 1</option>";
        $optionsProducts .= "<option value='2'>Produto 2</option>";
        $optionsProducts .= "<option value='3'>Produto 3</option>";

        return <<<HTML
<section>
    <h1>Vendas</h1>
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
    <div class="grid">
        <button data-target="modal-newProduct"
            onclick="">Nova venda</button>
    </div>
</section>

HTML;
    }
}

