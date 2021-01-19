import Layout from '../views/front/layouts';
import Home from '../views/front';

import { config } from '../common/config';

export default [
    {
        path: '',
        component: Home,
        name: 'home',
        meta: {
            layout: Layout,
            role: 'public',
            show: {
                footer: true
            },
            title: 'ログイン | ' + config.site_name
        }
    }
];