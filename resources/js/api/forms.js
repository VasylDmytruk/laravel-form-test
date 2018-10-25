
export default {

    _baseUrl: 'http://todo.lc',

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

    getForms(callback, errorCallback) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/forms');
    },

    getForm(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/forms/' + id);
    },

    deleteForm(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/forms/' + id, 'delete');
    },

    createForm(callback, errorCallback, form) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/forms', 'post', form);
    },

    updateForm(callback, errorCallback, {id, form}) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/forms/' + id, 'put', form);
    },
}