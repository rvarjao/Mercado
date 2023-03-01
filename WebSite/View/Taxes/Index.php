<?php

namespace View\Taxes;

use Model\Market\ProductTypeTax;
use View\Selects\ProductTypes;
use View\View;

class Index implements View
{
    public function render($data = null): string
    {
        $productTypes = new ProductTypes();
        $selectProductTypes = $productTypes->render();

        $trs = "";
        $productTypeTaxes = ProductTypeTax::findCurrentTax();
        foreach ($productTypeTaxes as $productTypeTax) {
            $tr = new TableRow();
            $trs .= $tr->render($productTypeTax);
        }

        return <<<HTML
        <section>
            <h1>Impostos deduzidos nos tipos de produtos</h1>
            <a role="button" href=# data-target="modal-newProduct"
                    onclick="toggleModal(event)">Novo imposto do tipo de produto</a>
            <table id="productTypes" role="grid">
                <thead>
                    <tr>
                        <th hidden>Id</th>
                        <th>Tipo</th>
                        <th>Imposto (%)</th>
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
        <h5>Novo imposto de tipo de produto</h5>
        <form>
            $selectProductTypes
            <label for="tax">Percentagem do imposto retido (%)
                <input type="number" id="tax" name="tax" step="0.01"/>
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
                    onClick="ProductTypeTaxView.saveTax(event);">
                    Salvar
                </a>
            </footer>
        </form>
    </article>
</dialog>


HTML;
    }
}
