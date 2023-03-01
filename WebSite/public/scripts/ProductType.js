"use strict";

class ProductType {

    constructor(productType = { id: 0, name: '' }) {
        this.id = productType.id ?? 0;
        this.name = productType.name ?? '';
    }

    save() {
        const url = `controllers/product_type.php`;
        const data = new FormData();
        data.append('id', this.id);
        data.append('name', this.name);
        data.append('description', this.description);
        return fetch(url, {
            method: 'POST',
            body: data
        }).then(response => response.json())
    }

}

class ProductTypeView {
    static init() {
        loadView('productTypes/index').
            then(() => {
                ;
                const form = document.getElementById('formProductType');
                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    ProductType.submitForm(event);
                })
            });

    }

    static saveProductType() {
        const form = document.getElementById('formProductType');
        const name = form.querySelector('input[name="name"]').value;
        const productType = new ProductType({ name: name });
        productType.save().then((data) => {
            if (data.success === true) {
                const modal = document.getElementById('modal-newProductType');
                closeModal(modal);
                System.loadView('productTypes/index');
            } else {
                alert('Erro ao salvar o tipo de produto');
            }
        });
    }
}
