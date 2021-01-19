import AuthLayout from '../views/admin/layouts/Auth.vue';
import Login from '../views/admin/auth/Login.vue';

import { config } from '../common/config';

export default [
    {
        path: '/admin',
        component: {
            render: c => c('router-view')
        },
        children: [
            {
                path: '',
                component: Login,
                name: 'admin.auth.login',
                meta: {
                    layout: AuthLayout,
                    role: 'admin',
                    show: {
                        footer: true
                    },
                    title: '管理者 | ログイン | ' + config.site_name
                }
            },
            {
                path: 'login',
                redirect: {
                    name: 'admin.auth.login'
                }
            }
        ]
    }
];