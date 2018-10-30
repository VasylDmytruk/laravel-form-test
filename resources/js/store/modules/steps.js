import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import crud from '../../api/crud';

const steps = cloneDeep(crud);
const stepsModule = cloneDeep(crudModule);

steps.route = 'steps';
stepsModule.state.crudApi = steps;

export default stepsModule;
