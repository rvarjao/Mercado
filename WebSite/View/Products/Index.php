<?php

namespace View\Products;

use Model\Market\Product;
use Model\Market\ProductType;
use View\Selects\ProductTypes;
use View\View;

class Index implements View
{
    public function render($data = null): string
    {

        $products = Product::findAll();
        $trs = '';
        foreach ($products as $product) {
            $trs .= (new TableRow())->render($product);
        }

        $viewProductTypes = new ProductTypes();
        $selectProductTypes = $viewProductTypes->render();

        return <<<HTML
<section>
    <h1>Produtos</h1>
    <a href=# role="button" data-target="modal-newProduct"
        onclick="toggleModal(event)">Novo produto</a>
    <table id="productTypes" role="grid">
        <thead>
            <tr>
                <th hidden>Id</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            $trs
        </tbody>
    </table>

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
            $selectProductTypes
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
                onClick="ProductView.saveProduct(event)">
                Salvar
            </a>
            </footer>
        </form>
    </article>
</dialog>

HTML;
    }
}
