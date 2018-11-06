import cloneDeep  from 'clone-deep';
import crud from '../../api/crud';
import crudModule from './crud';

const formsCrudModule = cloneDeep(crudModule);
const forms = cloneDeep(crud);

forms.route = 'forms';
formsCrudModule.state.crudApi = forms;
formsCrudModule.mutations.seItem = function (state, item) {
    state.lastItem = item;

    if (item.data) {
        try {
            state.lastItem.data = JSON.parse(item.data);
        } catch (e) {
        }
    }

    state.setCachedItem(state.lastItem);
};

export default formsCrudModule;
