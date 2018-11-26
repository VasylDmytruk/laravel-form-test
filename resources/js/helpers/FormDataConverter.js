
export default class FormDataConverter {
    static convertItemFormDataIfNeed(item) {
        if (item.form && item.form.data) {
            try {
                item.form.data = JSON.parse(item.form.data);
            } catch (e) {
            }
        }
    }

    static convertItemsFormDataIfNeed(items) {
        items.forEach(item => {
            FormDataConverter.convertItemFormDataIfNeed(item);
        });
    }
}
