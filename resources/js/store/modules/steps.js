import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import crud from '../../api/crud';

const steps = cloneDeep(crud);
const stepsModule = cloneDeep(crudModule);

steps.route = 'steps';
stepsModule.state.crudApi = steps;
stepsModule.mutations.seItem = function (state, item) {
    state.lastItem = item;

    if (item.form && item.form.data) {
        console.log('item.form.data steps.js', item.form.data);
        try {
            state.lastItem.form.data = JSON.parse(item.form.data);
        } catch (e) {
        }
    }

    state.setCachedItem(state.lastItem);
};

export default stepsModule;
