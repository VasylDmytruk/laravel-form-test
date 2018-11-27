import Vue from 'vue';

const defaultActiveStep = {
    done: false,
    form: {
        data: null,
    },
    healing_methods: '',
    id: null,
    index: 0,
    step_order: 0,
    title: '',
};

export default {
    namespaced: true,
    state: {
        activeStep: defaultActiveStep,
    },
    mutations: {
        setActiveStep(state, {step, index}) {
            state.activeStep = step;
            state.activeStep.index = index;
        },
        resetActiveStep(state) {
            state.activeStep = defaultActiveStep;
        },
        setDone(state) {
            Vue.set(state.activeStep, 'done', true);
        },
    },
    actions: {},
    getters: {},
};
