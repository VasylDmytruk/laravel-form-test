import _ from 'lodash';
import crud from '../../api/crud';
import crudModule from './crud';

const formsCrudModule = _.cloneDeep(crudModule);
const forms = _.cloneDeep(crud);

forms.route = 'forms';
formsCrudModule.state.crudApi = forms;

export default formsCrudModule;
