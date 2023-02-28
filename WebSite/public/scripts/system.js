class System {
    constructor() {
        this._init();
    }

    _init() {

    }

    static loadView(view) {

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
    return System.loadView(view).then((html) => {
        document.getElementById('viewContent').innerHTML = html;
    })
}
