import Vue from 'vue';
import Vuex from 'vuex';
import forms from './modules/forms';
import steps from './modules/steps';
import menu from './modules/menu';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        forms,
        menu,
        steps,
    },
})
