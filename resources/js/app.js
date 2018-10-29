
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import VueRouter from 'vue-router';
import {mapState} from 'vuex';
import store from './store'
import Notifications from 'vue-notification';
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
import FormBuilder from 'autoxloo-form-builder';
import FormsIndex from './components/forms/FormsIndex';
import FormsCreate from './components/forms/FormsCreate';
import FormsEdit from './components/forms/FormsEdit';
import FormsView from './components/forms/FormsView';
import PassportView from './components/Passport';
import StepIndex from './components/steps/Index';
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css';

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(Notifications);
Vue.use(VueGoodTablePlugin);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));
Vue.component('form-builder', FormBuilder);

const routes = [
    {path: '/', component: FormsIndex},
    {path: '/forms/create', component: FormsCreate},
    {path: '/forms/edit/:id', component: FormsEdit},
    {path: '/forms/view/:id', component: FormsView},
    {path: '/passport-view', component: PassportView},
    {path: '/steps', component: StepIndex},
];

const router = new VueRouter({routes});

const app = new Vue({
    router,
    store,
    computed: mapState({
        menuItems: state => state.menu.menuItems,
    }),
}).$mount('#app');
