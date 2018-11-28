const typeSuccess = 'success';
const typeError = 'error';
const typeWarning = 'warn';

export default class NotificationHelper {
    static get TYPE_SUCCESS() {
        return typeSuccess;
    }

    static get TYPE_ERROR() {
        return typeError;
    }

    static get TYPE_WARNING() {
        return typeWarning;
    }
}
