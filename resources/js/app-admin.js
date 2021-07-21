require('./bootstrap');

window.axios.interceptors.response.use(function (response) {
    if(_.includes([403], response.data.code) && !(_.includes(["/admin/dashboards"], window.location.pathname))) {
        window.location = '/admin/dashboards';
        alert('Tính năng đang phát triển');
        return Promise.reject(response.data.message);
    }
    return response;
    }, function (error) {
        if (error.response) {
            if((_.includes([401,419], error.response.status)) 
                && !(_.includes(["/admin", "/admin/", "/admin/login", "/admin/login/"], window.location.pathname))) {
                window.location.reload();
            };
            if(_.includes([403, 500], error.response.status)) {
                window.location = '/admin/dashboards';
                alert('Tính năng đang phát triển');
                return Promise.reject(response.data.message);
            }
        }
});

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

    if (to.query.test && envBuild === 'server') {
        next();
        return;
    }

    if (store.state.auth.authenticated) {
        if (to.name === "admin.auth.login") {
            window.location = window.origin + '/' + store.state.auth.redirectUrl;
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
            window.location = window.origin + '/' + store.state.auth.redirectLogoutUrl;
            return;
        }
    }

    next();
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
/*import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                axios.post('/api/broadcasting/auth', {
                    socket_id: socketId,
                    channel_name: channel.name
                })
                .then(response => {
                    callback(false, response.data);
                })
                .catch(error => {
                    callback(true, error);
                });
            }
        };
    },
});*/

if (envBuild == 'development') {
    console.log('ENV:', envBuild);
    console.log('STORE:', store);
    console.log('ROUTE:', routes);
}

store.dispatch('auth/admin', {
    type: 'init'
}).then(() => {
    return new Vue({
        el: '#gp-phu-cuong',
        router,
        store
    })
})