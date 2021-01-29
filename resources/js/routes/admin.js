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
                    title: 'Login | ' + config.site_name
                }
            },
            {
                path: 'dashboard',
                component: Users,
                name: 'admin.dashboard',
                meta: {
                    layout: MainLayout,
                    role: 'admin',
                    show: {
                        footer: true
                    },
                    title: 'Dashboard | ' + config.site_name
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
                                    name: 'Users List',
                                    link: 'admin.dashboard'
                                },
                                {
                                    name: 'Users'
                                }
                            ],
                            header: 'Users List',
                            layout: MainLayout,
                            role: 'admin',
                            title: 'Users | ' + config.site_name
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
                                    name: 'News Groups List',
                                    link: 'admin.dashboard'
                                },
                                {
                                    name: 'News Groups'
                                }
                            ],
                            header: 'News Groups List',
                            layout: MainLayout,
                            role: 'admin',
                            title: 'News Groups | ' + config.site_name
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
                                    name: 'News List',
                                    link: 'admin.dashboard'
                                },
                                {
                                    name: 'News'
                                }
                            ],
                            header: 'News List',
                            layout: MainLayout,
                            role: 'admin',
                            title: 'News | ' + config.site_name
                        }
                    }
                ]
            }
        ]
    }
];