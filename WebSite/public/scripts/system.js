class System {
    constructor() {
        this._init();
    }

    _init() {

    }

    static loadView(view, formData = null) {

        return new Promise((resolve, reject) => {
            const url = `controllers/views.php`;
            const data = formData ?? new FormData();
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


function loadView(view, formData = null) {
    return System.loadView(view, formData).then((html) => {
        document.getElementById('viewContent').innerHTML = html;
    })
}
