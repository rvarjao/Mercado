<?php

namespace View\ProductTypes;

use Model\Market\ProductType;
use View\View;

class Index implements View
{
    public function render($data = null): string
    {

        $productTypes = ProductType::findAll();
        $trs = '';

        foreach ($productTypes as $productType) {
            $tr = new TableRow();
            $trs .= $tr->render($productType);
        }

        return <<<HTML

<section>
    <h1>Tipos de Produtos</h1>
        <a href=# role="button" data-target="modal-newProductType"
            onclick="toggleModal(event)">Novo tipo de produto</a>
    <table id="productTypes" role="grid">
        <thead>
            <tr>
                <th hidden>Id</th>
                <th>Descrição</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            $trs
        </tbody>
    </table>
</section>


<!-- Modal -->
<dialog id="modal-newProductType">
<article style="min-width:20rem">
    <a href="#close"
    aria-label="Close"
    class="close"
    data-target="modal-newProductType"
    onClick="toggleModal(event)">
    </a>
    <h5>Novo tipo de produto</h5>
    <form id="formProductType">
        <label for="name">Descrição
            <input type="text" id="name" name="name" autocomplete="off" />
        </label>
    </form>
    <footer>
    <a href="#cancel"
        role="button"
        class="secondary"
        data-target="modal-newProductType"
        onClick="toggleModal(event)">
        Cancelar
    </a>
    <a href="#confirm"
        role="button"
        data-target="modal-newProductType"
        onClick="ProductTypeView.saveProductType(event)">
        Salvar
    </a>
    </footer>
</article>
</dialog>


HTML;
    }
}
