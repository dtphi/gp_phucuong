import AuthLayout from '../views/admin/layouts/auth';
import MainLayout from '../views/admin/layouts/Main';
import Login from '../views/admin/auth/Login';
import Users from '../views/admin/users';

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
            },
            {
                path: 'users',
                component: {render: c => c('router-view')},
                children: [
                    {
                        path: '',
                        component: Users,
                        name: 'admin.users.list',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'admin.menu.main.menu'
                                },
                                {
                                    name: '営業担当者'
                                }
                            ],
                            header: '営業担当者',
                            layout: MainLayout,
                            role: 'admin',
                            title: '管理者 | 営業担当者 | ' + config.site_name
                        }
                    }
                ]
            }
        ]
    }
];