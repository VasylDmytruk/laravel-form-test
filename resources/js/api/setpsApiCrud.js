import cloneDeep from 'clone-deep';
import crud from './crud';

const steps = cloneDeep(crud);
steps.route = 'steps';

export default steps;
