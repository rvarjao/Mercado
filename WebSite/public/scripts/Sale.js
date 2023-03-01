"use strict";

class Sale {
    static fromFormData(formData) {
        const productTypeTax = new ProductTypeTax();
        productTypeTax.id = formData.get('id');
        productTypeTax.productTypeId = formData.get('productTypeId') ?? formData.get('product_type_id');
        productTypeTax.tax = formData.get('tax');
        productTypeTax.createdAt = formData.get('createdAt') ?? formData.get('created_at');
        return productTypeTax;
    }

    constructor(product = {
        id: 0,
        productTypeId: 0,
        tax: 0,
        createdAt: '',
    }) {

        this.id = product.id ?? 0;
        this.productTypeId = product.productTypeId ?? 0;
        this.tax = product.tax ?? 0;
        this.createdAt = product.createdAt ?? '';
        console.log(this);
    }

    save() {
        const url = `controllers/product_tax.php`;
        const data = new FormData();
        data.append('id', this.id);
        data.append('tax', this.tax);
        data.append('product_type_id', this.productTypeId);
        return fetch(url, {
            method: 'POST',
            body: data
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


    static saveTax(event) {
        const buttonTarget = event.target;
        const form = buttonTarget.closest('form');
        const formData = new FormData(form);
        const productTypeTax = ProductTypeTax.fromFormData(formData);

        productTypeTax.save().then((data) => {
            if (data.success === true) {
                const modal = document.getElementById('modal-newProduct');
                closeModal(modal);
                loadView('sales/index');
            } else {
                alert('Erro ao salvar o imposto do tipo de produto');
            }
        });
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

    }

}