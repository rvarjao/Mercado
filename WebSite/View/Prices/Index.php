<?php

namespace View\Prices;

use View\View;

class Index implements View
{
    public function render($data = null): string
    {
        $trs = "";
        $data = [];
        foreach ($data as $price) {
            $tr = new TableRow();
            $trs .= $tr->render($price);
        }

        $optionsProducts = "";
        $optionsProducts .= "<option value=''>Selecione</option>";
        $optionsProducts .= "<option value='1'>Produto 1</option>";
        $optionsProducts .= "<option value='2'>Produto 2</option>";
        $optionsProducts .= "<option value='3'>Produto 3</option>";

        return <<<HTML
        <section>
            <h1>Preços dos produtos</h1>
            <table id="productTypes" role="grid">
                <thead>
                    <tr>
                        <th hidden>Id</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Valor (R$)</th>
                        <th>Data inclusão</th>
                    </tr>
                </thead>
                <tbody>
                    $trs
                </tbody>
            </table>
            <div class="grid">
                <button data-target="modal-newProduct"
                    onclick="toggleModal(event)">Novo produto</button>
            </div>
        </section>


<!-- Modal -->
<dialog id="modal-newProduct">
    <article style="min-width:20rem">
        <a href="#close"
        aria-label="Close"
        class="close"
        data-target="modal-newProduct"
        onClick="toggleModal(event)">
        </a>
        <h5>Novo preço de produto</h5>
        <form>
            <label for="type">Tipo
                <select name="type" id="type">
                    $optionsProducts
                </select>
            </label>
            <label for="value">Valor (R$)
                <input type="number" id="value" name="value" step="0.01"/>
            </label>

        </form>
    <footer>
        <a href="#cancel"
            role="button"
            class="secondary"
            data-target="modal-newProduct"
            onClick="toggleModal(event)">
            Cancel
        </a>
        <a href="#confirm"
            role="button"
            data-target="modal-newProduct"
            onClick="Product.create()">
            Salvar
        </a>
    </footer>
    </article>
</dialog>


HTML;
    }
}
