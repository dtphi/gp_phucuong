require('./bootstrap');

import Vue from 'vue';
import store from 'store@admin';
import Router from 'vue-router';
import routes from './routes/admin';

Vue.use(Router);
window.vue = Vue;
require('./views/admin/App');

const router = new Router({
    history: true,
    mode: 'history',
    routes: [
        ...routes
    ]
});

const envBuild = process.env.NODE_ENV;
router.beforeEach(async (to, from, next) => {
    document.title = to.meta.title;

    if (to.query.test && envBuild === 'development') {
    	next();
    	return;
    }

    if (store.state.auth.authenticated) {
    	if (to.name === "admin.auth.login") {
    		window.location = window.origin + '/admin/users';
    		return;
    	} else {
    		next();
    		return;
    	}
    } else {
    	if (to.name === "admin.auth.login") {
    		next();
    		return;
    	} else {
    		window.location = window.origin + '/admin/login';
    		return;
    	}
    }
    next();
});

if (envBuild == 'development') {
    console.log('ENV:', envBuild);
    console.log('STORE:',store);
    console.log('ROUTE:', routes);
}

store.dispatch('auth/admin', {type:'init'}).then(() => {
	return new Vue({
    el: '#gp-phu-cuong',
    router,
    store
	})
})
