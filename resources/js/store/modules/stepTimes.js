import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import crud from '../../api/crud';

const stepTimes = cloneDeep(crud);
const stepTimesModule = cloneDeep(crudModule);

stepTimes.route = 'step-time';
stepTimesModule.state.crudApi = stepTimes;

export default stepTimesModule;
