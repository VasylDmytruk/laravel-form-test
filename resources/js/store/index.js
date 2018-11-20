import Vue from 'vue';
import Vuex from 'vuex';
import forms from './modules/forms';
import steps from './modules/steps';
import stepTimes from './modules/stepTimes';
import menu from './modules/menu';
import activeStep from './modules/activeStep';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        forms,
        steps,
        stepTimes,
        menu,
        activeStep,
    },
})
