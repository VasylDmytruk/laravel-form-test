import cloneDeep from 'clone-deep';
import crud from './crud';

const stepsProcedures = cloneDeep(crud);
stepsProcedures.route = 'step-procedure';

export default stepsProcedures;
