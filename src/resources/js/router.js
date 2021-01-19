import Vue from 'vue';
import Router from 'vue-router';

import fronts from './routes/front';
import admins from './routes/admin';

import store from './stores';

Vue.use(Router);

const router = new Router({
    history: true,
    mode: 'history',
    routes: [
        ...fronts,
        ...admins
    ]
});

router.beforeEach(async (to, from, next) => {
    document.title = to.meta.title;
    next();
});

export default router;