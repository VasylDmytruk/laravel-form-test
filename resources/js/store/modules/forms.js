import Vue from 'vue';
import forms from '../../api/forms';

export default {
    namespaced: true,
    state: {
        allForms: [],
        lastForm: null,
        cachedForms: [],
        lastError: null,

        hasCachedForm(id) {
            return this.cachedForms[id] !== undefined;
        },
        getCachedForm(id) {
            return this.cachedForms[id] ? this.cachedForms[id] : null;
        },
        setCachedForm(form) {
            Vue.set(this.cachedForms, form.id, form);
        },
        getDefaultForm() {
            return {
                name: '',
                data: null,
            };
        },
    },
    mutations: {
        setForms(state, forms) {
            state.allForms = forms;
        },
        setError(state, error) {
            state.lastError = error;
        },
        seForm(state, form) {
            state.lastForm = form;

            if (form.data) {
                try {
                    state.lastForm.data = JSON.parse(form.data);
                } catch (e) {
                }
            }

            state.setCachedForm(state.lastForm);
        },
        resetForm(state) {
            state.lastForm = null;
            state.lastForm = state.getDefaultForm();
        },
        setFormFromCache(state, id) {
            state.lastForm = state.getCachedForm(id);
        },
        deleteForm(state, {response, index}) {
            if (response.success) {
                state.allForms.splice(index, 1);
            }
        },
    },
    actions: {
        getForms({commit}) {
            forms.getForms(
                forms => {commit('setForms', forms)},
                error => {commit('setError', error)},
            );
        },
        getForm({commit, state}, id) {
            commit('resetForm');

            if (state.hasCachedForm(id)) {
                commit('setFormFromCache', id);
            } else {
                forms.getForm(
                    form => {commit('seForm', form)},
                    error => {commit('setError', error)},
                    id,
                );
            }
        },
        deleteForm({commit}, {id, index}) {
            if (!confirm('Do you really want to delete this item')) {
                return;
            }

            return new Promise((resolve, reject) => {
                forms.deleteForm(
                    response => {
                        commit('deleteForm', {response, index});
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
        createForm({commit}, form) {
            return new Promise((resolve, reject) => {
                forms.createForm(
                    response => {
                        resolve(response);
                    },
                    error => {
                        reject(error);
                    },
                    form
                );
            });
        },
        updateForm({commit}, {id, form}) {
            return new Promise((resolve, reject) => {
                forms.updateForm(
                    response => {
                        resolve(response);
                    },
                    error => {
                        reject(error);
                    },
                    {id, form}
                );
            });
        },
    },
    getters: {},
}
