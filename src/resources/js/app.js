require('./bootstrap');

import Vue from 'vue';
import router from './router';
import store from './stores';

window.Vue = Vue;

new Vue({
    el: '#gp-phu-cuong',
    router,
    store
});