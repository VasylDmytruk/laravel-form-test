
export default {

    route: '',

    _baseUrl: 'http://todo.lc',

    _apiRequest(callback, errorCallback, url, method, data) {
        method = method || 'get';
        data = data || null;

        console.log('url', url);
        console.log('method', method);
        console.log('data', data);

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

    getItems(callback, errorCallback) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/' + this.route);
    },

    getItem(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/' + this.route + '/' + id);
    },

    deleteItem(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/' + this.route + '/' + id, 'delete');
    },

    createItem(callback, errorCallback, item) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/' + this.route, 'post', item);
    },

    updateItem(callback, errorCallback, {id, item}) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/' + this.route + '/' + id, 'put', item);
    },
}