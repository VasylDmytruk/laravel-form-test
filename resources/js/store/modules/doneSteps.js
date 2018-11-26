import stepsApiCrud from '../../api/setpsApiCrud';
import stepProceduresApiCrud from '../../api/stepProceduresApiCrud';
import FormDataConverter from '../../helpers/FormDataConverter';

export default {
    namespaced: true,
    state: {
        doneSteps: [],
    },
    mutations: {
        setDoneSteps(state, items) {
            if (state.doneSteps.length === 0) {
                FormDataConverter.convertItemsFormDataIfNeed(items);
                state.doneSteps = items;
            } else if ((items.length - state.doneSteps.length) > 0) {
                for (let i = state.doneSteps.length; i < items.length; ++i) {
                    let item = items[i];

                    FormDataConverter.convertItemFormDataIfNeed(item);

                    state.doneSteps.push(item);
                }
            }
        },
        resetDoneSteps(state) {
            state.doneSteps = [];
        },
    },
    actions: {
        getDoneSteps({commit, state}) {
            stepsApiCrud.getItems(
                items => {
                    commit('setDoneSteps', items);
                },
                error => {
                    commit('setError', error);
                },
            );
        },
        resetDoneSteps({commit, state}) {
            commit('resetDoneSteps');

            this.getDoneSteps({commit, state});
        },
        createDoneSteps({commit, state}, data) {
            return new Promise((resolve, reject) => {
                stepProceduresApiCrud.createItem(
                    response => {
                        resolve(response);
                    },
                    error => {
                        reject(error);
                    },
                    data
                );
            });
        },
    },
    getters: {},
};
