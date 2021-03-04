import AuthLayout from 'v@admin/layouts/auth';
import MainLayout from 'v@admin/layouts/Main';
import Login from 'v@admin/auth/Login';
import Users from 'v@admin/users';
import NewsGroups from 'v@admin/newsgroups';
import News from 'v@admin/news';
import NewsAdd from 'v@admin/news/add';
import NewsEdit from 'v@admin/news/edit';
import FileManager from 'v@admin/filemanagers';

import {
    config
} from '../common/config';

export default [{
    path: '/admin',
    component: {
        render: c => c('router-view')
    },
    children: [{
        path: '',
        redirect: {
            name: 'admin.auth.login'
        }
    }, {
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
    }, {
        path: 'dashboard',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: Users,
            name: 'admin.dashboard',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard'
                }],
                header: 'Dashboard',
                layout: MainLayout,
                role: 'admin',
                title: 'Users | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }]
    }, {
        path: 'users',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: Users,
            name: 'admin.users.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'Users'
                }],
                header: 'Users List',
                layout: MainLayout,
                role: 'admin',
                title: 'Users | ' + config.site_name
            }
        }]
    }, {
        path: 'news-groups',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: NewsGroups,
            name: 'admin.newsgroups.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'News Groups'
                }],
                header: 'News Groups List',
                layout: MainLayout,
                role: 'admin',
                title: 'News Groups | ' + config.site_name
            }
        }]
    }, {
        path: 'news',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: News,
            name: 'admin.news.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'News'
                }],
                header: 'News List',
                layout: MainLayout,
                role: 'admin',
                title: 'News | ' + config.site_name
            }
        }, {
            path: 'add',
            component: NewsAdd,
            name: 'admin.news.add',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'News',
                    linkName: 'admin.news.list',
                    linkPath: '/news'
                }, {
                    name: 'News Add'
                }],
                header: 'News Add',
                layout: MainLayout,
                role: 'admin',
                title: 'News Add | ' + config.site_name
            }
        }, {
            path: 'edit/:infoId',
            component: NewsEdit,
            name: 'admin.news.edit',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'News',
                    linkName: 'admin.news.list',
                    linkPath: '/news'
                }, {
                    name: 'News Edit'
                }],
                header: 'News Edit',
                layout: MainLayout,
                role: 'admin',
                title: 'News Edit | ' + config.site_name
            }
        }]
    }, {
        path: 'filemanagers',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: FileManager,
            name: 'admin.filemanagers.list',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'Filemanagers'
                }],
                header: 'Filemanagers List',
                layout: MainLayout,
                role: 'admin',
                title: 'Filemanagers | ' + config.site_name
            }
        }]
    }]
}];