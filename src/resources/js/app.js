require('./bootstrap');

import Vue from 'vue';
import router from './router';
import store from './stores';


window.vue = Vue;

new Vue({
    el: '#gp-phu-cuong',
    router,
    store
});