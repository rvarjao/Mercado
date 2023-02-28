class System {
    constructor() {
        this._init();
    }

    _init() {

    }

    static getView(view) {

        return new Promise((resolve, reject) => {
            const url = `controllers/views.php`;
            const data = new FormData();
            data.append('view', view);
            fetch(url, {
                method: 'POST',
                body: data
            }).then((response) => {
                response.text().then((html) => {
                    resolve(html);
                });
            });
        });

    }

}


function loadView(view) {
    System.getView(view).then((html) => {
        document.getElementById('viewContent').innerHTML = html;
    });
}
