<?php

namespace View\Products;

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
    <h1>Tipos de Produtos</h1>
    <table id="productTypes" role="grid">
        <thead>
            <tr>
                <th hidden>Id</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Valor (R$)</th>
                <th></th>
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
        <h5>Novo produto</h5>
        <form>
            <label for="name">Descrição
                <input type="text" id="name" name="name" autocomplete="off" />
            </label>
            <label for="name">Descrição
                <select>
                    $optionsProducts
                </select>
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

