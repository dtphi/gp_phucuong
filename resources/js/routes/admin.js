import AuthLayout from 'v@admin/layouts/auth';
import MainLayout from 'v@admin/layouts/Main';
import Login from 'v@admin/auth/Login';
import Users from 'v@admin/users';
import NewsGroups from 'v@admin/newsgroups';
import News from 'v@admin/news';

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
                redirect: {
                    name: 'admin.auth.login'
                }
            },
            {
                path: 'login',
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
            },
            {
                path: 'news-groups',
                component: {render: c => c('router-view')},
                children: [
                    {
                        path: '',
                        component: NewsGroups,
                        name: 'admin.newsgroups.list',
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
            },
            {
                path: 'news',
                component: {render: c => c('router-view')},
                children: [
                    {
                        path: '',
                        component: News,
                        name: 'admin.news.list',
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