import _ from 'lodash';
import crudModule from '../modules/crud';
import crud from '../../api/crud';

const steps = _.cloneDeep(crud);
const stepsModule = _.cloneDeep(crudModule);

steps.route = 'steps';
stepsModule.state.crudApi = steps;

export default stepsModule;
