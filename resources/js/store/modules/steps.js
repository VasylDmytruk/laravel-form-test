import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import crud from '../../api/crud';

const steps = cloneDeep(crud);
const stepsModule = cloneDeep(crudModule);

steps.route = 'steps';
stepsModule.state.crudApi = steps;

stepsModule.convertItemFormDataIfNeed = function (item) {
    if (item.form && item.form.data) {
        try {
            item.form.data = JSON.parse(item.form.data);
        } catch (e) {
        }
    }
};

stepsModule.mutations.seItem = function (state, item) {
    stepsModule.convertItemFormDataIfNeed(item);

    state.lastItem = item;
    state.setCachedItem(state.lastItem);
};

stepsModule.mutations.setItems = function (state, items) {
    items.forEach(function (item) {
        stepsModule.convertItemFormDataIfNeed(item);
    });

    state.allItems = items;
};

export default stepsModule;
