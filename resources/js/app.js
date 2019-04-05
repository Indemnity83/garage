import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import Navbar from './components/Navbar.vue';

require('./bootstrap');

Vue.use(VueRouter);
Vue.component('navbar', Navbar);
Vue.prototype.$eventBus = new Vue();

const app = new Vue({
    el: '#app',

    router: new VueRouter(routes)
});
