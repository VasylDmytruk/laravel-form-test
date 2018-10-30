import cloneDeep  from 'clone-deep';
import crud from '../../api/crud';
import crudModule from './crud';

const formsCrudModule = cloneDeep(crudModule);
const forms = cloneDeep(crud);

forms.route = 'forms';
formsCrudModule.state.crudApi = forms;

export default formsCrudModule;
