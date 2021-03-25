import MainLayout from 'v@front/layouts/main';
import HomePage from 'v@front/page_homes';

//test
import Home from 'v@front/home';
import HomeLayout from 'v@front/layouts';

import { config } from '../common/config';

export default [
    {
        path: '',
        component: Home,
        name: 'home',
        meta: {
            layout: HomeLayout,
            role: 'public',
            show: {
                footer: true
            },
            title: 'ログイン | ' + config.site_name
        },
        children: [{
            path: 'home-page',
            component: HomePage,
            name: 'home-page',
            meta: {
                layout: MainLayout,
                role: 'public',
                show: {
                    footer: true
                },
                title: 'ログイン | ' + config.site_name
            },
        }]
    }
];
