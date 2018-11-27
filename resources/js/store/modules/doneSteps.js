import stepsApiCrud from '../../api/setpsApiCrud';
import stepProceduresApiCrud from '../../api/stepProceduresApiCrud';
import FormDataConverter from '../../helpers/FormDataConverter';

export default {
    namespaced: true,
    state: {
        doneSteps: [],
        allStepsDone: false,
        getDataForSaving() {
            const doneStepsForSaving = [];
            let totalSpentTime = 0;

            this.doneSteps.forEach(item => {
                const itemForSaving = {
                    step_id: item.id,
                    form_data_value: item.form.data,
                    // TODO change it
                    spent_time: 1,
                };

                totalSpentTime += itemForSaving.spent_time;

                doneStepsForSaving.push(itemForSaving);
            });

            const dataForSaving = {
                done_steps: doneStepsForSaving,
                total_spent_time: totalSpentTime,
            };

            return dataForSaving;
        },
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
            } else if ((state.doneSteps.length - items.length) > 0) {
                // TODO implement merging
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

            stepsApiCrud.getItems(
                items => {
                    commit('setDoneSteps', items);
                },
                error => {
                    commit('setError', error);
                },
            );
        },
        createDoneSteps({commit, state}) {
            const data = state.getDataForSaving();

            console.log('createDoneSteps', data);

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
    getters: {
        areAllDone: (state) => () => {
            let allDone = true;

            for (let index in state.doneSteps) {
                const item = state.doneSteps[index];

                if (!item.done) {
                    allDone = false;
                    break;
                }
            }

            return allDone;
        },
    },
};
