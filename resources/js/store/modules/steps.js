import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import steps from '../../api/setpsApiCrud';
import FormDataConverter from '../../helpers/FormDataConverter';

const stepsModule = cloneDeep(crudModule);
stepsModule.state.crudApi = steps;

stepsModule.mutations.seItem = function (state, item) {
    FormDataConverter.convertItemFormDataIfNeed(item);

    state.lastItem = item;
    state.setCachedItem(state.lastItem);
};

stepsModule.mutations.setItems = function (state, items) {
    FormDataConverter.convertItemsFormDataIfNeed(items);

    state.allItems = items;
};

export default stepsModule;
