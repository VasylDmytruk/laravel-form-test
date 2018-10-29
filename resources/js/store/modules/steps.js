import Vue from 'vue';
import steps from '../../api/steps';

export default {
    namespaced: true,
    state: {
        allSteps: [],
        lastStep: null,
        cachedSteps: [],
        lastError: null,

        hasCachedStep(id) {
            return this.cachedSteps[id] !== undefined;
        },
        getCachedStep(id) {
            return this.cachedSteps[id] ? this.cachedSteps[id] : null;
        },
        setCachedStep(step) {
            Vue.set(this.cachedSteps, step.id, step);
        },
        getDefaultStep() {
            return {
                name: '',
                data: null,
            };
        },
    },
    mutations: {
        setSteps(state, steps) {
            state.allSteps = steps;
        },
        setError(state, error) {
            state.lastError = error;
        },
        seStep(state, step) {
            state.lastStep = step;

            if (step.data) {
                try {
                    state.lastStep.data = JSON.parse(step.data);
                } catch (e) {
                }
            }

            state.setCachedStep(state.lastStep);
        },
        resetStep(state) {
            state.lastStep = null;
            state.lastStep = state.getDefaultStep();
        },
        setStepFromCache(state, id) {
            state.lastStep = state.getCachedStep(id);
        },
        deleteStep(state, {response, index}) {
            if (response.success) {
                state.allSteps.splice(index, 1);
            }
        },
    },
    actions: {
        getSteps({commit}) {
            steps.getSteps(
                steps => {commit('setSteps', steps)},
                error => {commit('setError', error)},
            );
        },
        getStep({commit, state}, id) {
            commit('resetStep');

            if (state.hasCachedStep(id)) {
                commit('setStepFromCache', id);
            } else {
                steps.getStep(
                    step => {commit('seStep', step)},
                    error => {commit('setError', error)},
                    id,
                );
            }
        },
        deleteStep({commit}, {id, index}) {
            if (!confirm('Do you really want to delete this item')) {
                return;
            }

            return new Promise((resolve, reject) => {
                steps.deleteStep(
                    response => {
                        commit('deleteStep', {response, index});
                        resolve(response);
                    },
                    error => {
                        commit('setError', error);
                        reject(error);
                    },
                    id,
                );
            });
        },
        createStep({commit}, step) {
            return new Promise((resolve, reject) => {
                steps.createStep(
                    response => {
                        resolve(response);
                    },
                    error => {
                        reject(error);
                    },
                    step
                );
            });
        },
        updateStep({commit}, {id, step}) {
            return new Promise((resolve, reject) => {
                steps.updateStep(
                    response => {
                        resolve(response);
                    },
                    error => {
                        reject(error);
                    },
                    {id, step}
                );
            });
        },
    },
    getters: {},
}
