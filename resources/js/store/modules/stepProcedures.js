import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import stepProcedures from '../../api/stepProceduresApiCrud';
import FormDataConverter from '../../helpers/FormDataConverter';

const stepProceduresModule = cloneDeep(crudModule);
stepProceduresModule.state.crudApi = stepProcedures;

stepProceduresModule.mutations.seItem = function (state, item) {
    FormDataConverter.jsonParseItemsField(item.done_steps, 'form_data_value');

    state.lastItem = item;
    state.setCachedItem(state.lastItem);
};

stepProceduresModule.mutations.setItems = function (state, items) {
    items.forEach(item => {
        FormDataConverter.jsonParseItemsField(item.done_steps, 'form_data_value');
    });

    state.allItems = items;
};

export default stepProceduresModule;
