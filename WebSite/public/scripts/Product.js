"use strict";

class Product {
    constructor(product = { id: 0, name: '' , productTypeId: 0}) {
        this.id = product.id ?? 0;
        this.name = product.name ?? '';
        this.productTypeId = product.productTypeId ?? 0;
    }

    save() {
        const url = `controllers/product.php`;
        const data = new FormData();
        data.append('id', this.id);
        data.append('name', this.name);
        data.append('product_type_id', this.productTypeId);
        return fetch(url, {
            method: 'POST',
            body: data
        }).then(response => response.json())
    }
}


class ProductView {
    static init() {
        loadView('products/index');
    }

    static saveProduct(event) {
        const buttonTarget = event.target;
        const form = buttonTarget.closest('form');
        const formData = new FormData(form);
        const name = formData.get('name');
        const productTypeId = formData.get('productTypeId');

        const product = new Product({ name: name, productTypeId: productTypeId });

        product.save().then((data) => {
            if (data.success === true) {
                const modal = document.getElementById('modal-newProduct');
                closeModal(modal);
                loadView('products/index');
            } else {
                alert('Erro ao salvar o tipo de produto');
            }
        });
    }
}
