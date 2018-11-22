import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import crud from '../../api/crud';

const stepProcedures = cloneDeep(crud);
const stepProceduresModule = cloneDeep(crudModule);

stepProcedures.route = 'step-procedure';
stepProceduresModule.state.crudApi = stepProcedures;

export default stepProceduresModule;
