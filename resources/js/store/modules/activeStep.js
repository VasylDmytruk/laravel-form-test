import Vue from 'vue';

export default {
    namespaced: true,
    state: {
        activeStep: {
            done: false,
            form: {
                data: null,
            },
            healing_methods: '',
            id: null,
            index: 0,
            step_order: 0,
            title: '',
        },
    },
    mutations: {
        setActiveStep(state, {step, index}) {
            state.activeStep = step;
            state.activeStep.index = index;
        },
        setDone(state) {
            Vue.set(state.activeStep, 'done', true);
        },
    },
    actions: {},
    getters: {},
};