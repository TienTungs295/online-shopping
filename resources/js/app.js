/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent'));
Vue.component('app-component', require('./components/App'));

// import vue router, component và routes
import App from './components/App';
import Vue from 'vue';
import VueRouter from 'vue-router';
import VueToastr from "vue-toastr";
import routes from './routes';
Vue.prototype.vue_toastr= 'My App'
Vue.prototype.$test = "Test"


Vue.use(VueRouter);
Vue.use(VueToastr, {
    defaultTimeout: 1500,
    defaultProgressBar: false,
    defaultPosition: "toast-top-right",
    defaultCloseOnHover: true,
    defaultStyle: {"top": "50px"},
    defaultClassNames: ["animated", "zoomInUp"]
});
const router = new VueRouter({
    routes
});


const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});


