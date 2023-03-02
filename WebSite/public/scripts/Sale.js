"use strict";

class Sale {
    constructor(product = {
        id: 0,
        products: [],
    }) {

        this.id = product.id ?? 0;
        this.products = product.products ?? [];
    }

    static save(formData) {
        const url = `controllers/sale.php`;
        return fetch(url, {
            method: 'POST',
            body: formData
        }).then(response => response.json())
    }
}


class SalesView {
    static init() {
        loadView('sales/index');
    }

    static openNewSaleView() {
        loadView('sales/new');
    }

    static loadNewSaleView() {
        loadView('sales/detail/sale');
    }
}

class SaleView {
    static init() {

    }

    static loadNewSaleView() {
        loadView('sales/detail/sale');
    }

    static addRow() {
        System.loadView('sales/detail/tableRow')
        .then((data) => {
            const table = document.getElementById('tableSaleProducts');

            const tbody = table.querySelector('tbody');
            tbody.insertAdjacentHTML('beforeend', data);

            const row = tbody.lastElementChild;

            const productSelector = row.querySelector('select');
            productSelector.addEventListener('change', () => SaleView.updateRow(row));

            const inputAmount = row.querySelector('input[name="amount[]"]');
            inputAmount.addEventListener('input', () => SaleView.updateTotals(row));

            SaleView.updateRow(row);

        });
    }

    static updateRow(tr) {
        if (!tr) {
            return;
        }

        const data = new FormData();
        const select = tr.querySelector('select');
        if (!select) {
            return;
        }
        const productId = select.querySelector('option:checked');
        if (!productId) {
            return;
        }

        if (!parseInt(productId.value)) {
            return;
        }

        data.append('id', productId.value);
        const parameters = new URLSearchParams(data);
        const url = `controllers/product.php?${parameters}`;

        fetch(url, {
            method: 'GET',
        })
        .then((response) => response.json())
        .then((product) => {
            const inputPriceId = tr.querySelector('input[name="product_price_id[]"]');
            const inputTypeTaxId = tr.querySelector('input[name="product_type_tax_id[]"]');
            const inputPrice = tr.querySelector('input[name="price[]"]');
            const inputTypeTax = tr.querySelector('input[name="product_type_tax[]"]');
            const inputType = tr.querySelector('input[name="product_type[]"]');

            if (product.productPrice) {
                inputPriceId.value = product.productPrice.id;
                inputPrice.value = product.productPrice.price;
            }

            if (product.productTypeTax) {
                inputTypeTaxId.value = product.productTypeTax.id;
                inputTypeTax.value = product.productTypeTax.tax;
            }

            if (product.productType) {
                inputType.value = product.productType.name;
            }

            SaleView.updateTotals();
        })
        .catch((error) => {
            console.error('Error:', error);
        });

    }

    static updateTotals() {
        SaleView.updateRowsTotals();
        SaleView.updateSaleTotal();
    }

    static updateRowsTotals() {
        const table = document.getElementById('tableSaleProducts');
        const tbody = table.querySelector('tbody');
        const trs = tbody.querySelectorAll('tr');
        trs.forEach((tr) => {
            SaleView.updateRowTotal(tr);
        });
    }

    static updateRowTotal(tr) {
        const inputAmount = tr.querySelector('input[name="amount[]"]');
        const inputPrice = tr.querySelector('input[name="price[]"]');
        const inputProductTypeTax = tr.querySelector('input[name="product_type_tax[]"]');
        const inputTypeTaxValue = tr.querySelector('input[name="product_type_tax_value[]"]');
        const inputTotal = tr.querySelector('input[name="total[]"]');

        const amount = inputAmount.value ?? 0;
        const price = inputPrice.value ?? 0;
        const tax = inputProductTypeTax.value / 100 ?? 0;
        const totalTax = tax * amount * price ?? 0
        inputTypeTaxValue.value = totalTax;

        const total = (amount * price) + totalTax;
        inputTotal.value = total;
    }

    static updateSaleTotal() {
        const table = document.getElementById('tableSaleProducts');
        const tbody = table.querySelector('tbody');
        const trs = [...tbody.querySelectorAll('tr')];
        const inputsTotal = trs.map((tr) => tr.querySelector('input[name="total[]"]'));
        const total = inputsTotal.reduce((total, input) => total + parseFloat(input.value), 0);
        const inputTotal = document.getElementById('saleTotal');
        inputTotal.value = total;
    }

    static save() {
        const form = document.getElementById('formSale');
        const formData = new FormData(form);
        Sale.save(formData)
        .then((data) => {

            if (!data.success) {
                alert(data.message);
                return;
            }

            SalesView.init();
        })
        .catch((error) => {
            console.error('Error:', error);
        });


    }

}
