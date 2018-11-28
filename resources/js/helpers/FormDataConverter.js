
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

    static jsonParseItemField(item, field) {
        const value = item[field];

        if (value) {
            try {
                item[field] = JSON.parse(item[field]);
            } catch (e) {
            }
        }
    }

    static jsonParseItemsField(items, field) {

        items.forEach(item => {
            FormDataConverter.jsonParseItemField(item, field);
        });
    }
}
