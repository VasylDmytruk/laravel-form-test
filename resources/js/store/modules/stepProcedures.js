import cloneDeep from 'clone-deep';
import crudModule from '../modules/crud';
import stepProcedures from '../../api/stepProceduresApiCrud';

const stepProceduresModule = cloneDeep(crudModule);
stepProceduresModule.state.crudApi = stepProcedures;

export default stepProceduresModule;
