<?php

namespace View\Prices;

use View\View;
use Model\Market\ProductPrice;
use View\Selects\Products;
use View\Selects\ProductTypes;

class Index implements View
{
    public function render($data = null): string
    {

        $prices = ProductPrice::findCurrentPrice();
        $trs = '';
        foreach ($prices as $price) {
            $tr = new TableRow();
            $trs .= $tr->render($price);
        }

        $viewProductTypes = new Products();
        $selectProducts = $viewProductTypes->render();

        return <<<HTML
        <section>
            <h1>Preços dos produtos</h1>
            <a role="button" href=# data-target="modal-newProduct"
                    onclick="toggleModal(event)">Novo preço</a>
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
            $selectProducts
            <label for="price">Valor (R$)
                <input type="number" id="price" name="price" step="0.01"/>
            </label>
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
                    onClick="ProductPriceView.savePrice(event)">
                    Salvar
                </a>
            </footer>
        </form>
    </article>
</dialog>


HTML;
    }
}
