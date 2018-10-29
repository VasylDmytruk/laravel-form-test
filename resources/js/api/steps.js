
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

    getSteps(callback, errorCallback) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/steps');
    },

    getStep(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/steps/' + id);
    },

    deleteStep(callback, errorCallback, id) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/steps/' + id, 'delete');
    },

    createStep(callback, errorCallback, step) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/steps', 'post', step);
    },

    updateStep(callback, errorCallback, {id, step}) {
        this._apiRequest(callback, errorCallback, this._baseUrl + '/api/steps/' + id, 'put', step);
    },
}