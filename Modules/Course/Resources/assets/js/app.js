/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.config.devtools = true;

Vue.component('zoom-client', require('./components/ZoomClientComponent.vue').default);

window.app = new Vue({
    el: '#appVue',

    data(){
       return {

       }
    }
});
