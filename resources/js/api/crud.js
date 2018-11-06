
export default {

    route: '',
    sortAction: 'sort',

    _baseUrl: 'http://todo.lc/api',

    _apiRequest(callback, errorCallback, url, method, data) {
        method = method || 'get';
        data = data || null;

        axios({
            method: method,
            url: url,
            data: data
        })
            .then(response => {
                callback(response.data);
            })
            .catch(error => {
                errorCallback(error);
            });
    },

    sortItems(callback, errorCallback, items) {
        const url = this._baseUrl + '/' + this.route + '/' + this.sortAction;
        this._apiRequest(callback, errorCallback, url, 'post', items);
    },

    getItems(callback, errorCallback) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/' + this.route);
    },

    getItem(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/' + this.route + '/' + id);
    },

    deleteItem(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/' + this.route + '/' + id, 'delete');
    },

    createItem(callback, errorCallback, data) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/' + this.route, 'post', data);
    },

    updateItem(callback, errorCallback, {id, data}) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/' + this.route + '/' + id, 'put', data);
    },
}