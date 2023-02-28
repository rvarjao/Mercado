class ProductType {

    constructor(productType = {id: 0, name: ''}) {
        this.id = productType.id ?? 0;
        this.name = productType.name ?? '';
    }

    save () {
        const url = `controllers/product_type.php`;
        const data = new FormData();
        data.append('id', this.id);
        data.append('name', this.name);
        data.append('description', this.description);
        fetch(url, {
            method: 'POST',
            body: data
        }).then( response => response.json() )
        .then( data => {
            const event = new Event('click');
            event.target = document.querySelectorAll('modal-newProductType')[0];
            dispatchEvent(event);
            toggleModal(event);

            if (data.success === 'success') {
                System.loadView('productsTypes/index');
            } else {
                alert('Erro ao salvar o tipo de produto');
            }

        });
    }

    static submitForm(event) {
        const name = document.getElementById('name').value;
        const productType = new ProductType({name: name});
        productType.save();
        toggleModal(event);
    }

    static initScreen() {
        const form = document.getElementById('formProductType');
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            ProductType.submitForm(event);
        });
    }


}
