"use strict";

class ProductPrice {
    static fromFormData(formData) {
        const productPrice = new ProductPrice();
        productPrice.id = formData.get('id');
        productPrice.productId = formData.get('productId') ?? formData.get('product_id');
        productPrice.price = formData.get('price');
        productPrice.createdAt = formData.get('createdAt') ?? formData.get('created_at');
        return productPrice;
    }

    constructor(product = {
        id: 0,
        productId : 0,
        price: 0,
        createdAt: '',
    }) {

        this.id = product.id ?? 0;
        this.productId = product.productId ?? 0;
        this.price = product.price ?? 0;
        this.createdAt = product.createdAt ?? '';
    }

    save() {
        const url = `controllers/product_price.php`;
        const data = new FormData();
        data.append('id', this.id);
        data.append('price', this.price);
        data.append('product_id', this.productId);
        return fetch(url, {
            method: 'POST',
            body: data
        }).then(response => response.json())
    }
}


class ProductPriceView {
    static init() {
        loadView('prices/index');
    }

    static savePrice(event) {
        const buttonTarget = event.target;
        const form = buttonTarget.closest('form');
        const formData = new FormData(form);
        const productPrice = ProductPrice.fromFormData(formData);

        productPrice.save().then((data) => {
            if (data.success === true) {
                const modal = document.getElementById('modal-newProduct');
                closeModal(modal);
                loadView('prices/index');
            } else {
                alert('Erro ao salvar o preço de produto');
            }
        });
    }
}
