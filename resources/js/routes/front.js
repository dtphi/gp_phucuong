import MainLayout from 'v@front/layouts/main';
import HomePage from 'v@front/page_homes';

import { config } from '../common/config';

export default [
    {
        path: '',
        component: HomePage,
        name: 'home-page',
        meta: {
            layout: MainLayout,
            role: 'public',
            show: {
                footer: true
            },
            title: 'ログイン | ' + config.site_name
        }
    }
];
