import AuthLayout from 'v@admin/layouts/auth';
import MainLayout from 'v@admin/layouts/Main';
import Login from 'v@admin/auth/Login';
import Users from 'v@admin/users';
import NewsGroups from 'v@admin/newsgroups';
import News from 'v@admin/news';
import NewsAdd from 'v@admin/news/add';
import NewsEdit from 'v@admin/news/edit';
import FileManager from 'v@admin/filemanagers';

/*default layout*/
import DefaultLayout from 'v@admin/layouts/default';
import CategoryListPage from 'v@admin/categorys';
import CategoryEditPage from 'v@admin/categorys/edit';
import CategoryAddPage from 'v@admin/categorys/add';
import DashboardPage from 'v@admin/dashboards';

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
    },{
        path: 'dashboards',
        component: DashboardPage,
        name: 'admin.dashboards',
        meta: {
            layout: DefaultLayout,
            role: 'admin',
            show: {
                footer: true
            },
            title: 'DashboardPage | ' + config.site_name
        }
    }, {
        path: 'news-categories',
        component: {
            render: c => c('router-view')
        },
        children: [{
            path: '',
            component: CategoryListPage,
            name: 'admin.category.list',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản lý'
                }],
                header: 'CategoryList',
                role: 'admin',
                title: 'Users | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },
        {
            path: 'add',
            component: CategoryAddPage,
            name: 'admin.category.add',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản lý'
                }],
                header: 'CategoryAdd',
                role: 'admin',
                title: 'Users | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        },
        {
            path: 'edit/:categoryId',
            component: CategoryEditPage,
            name: 'admin.category.edit',
            meta: {
                layout: DefaultLayout,
                auth: true,
                breadcrumbs: [{
                    name: 'Quản lý'
                }],
                header: 'CategoryEdit',
                role: 'admin',
                title: 'Users | ' + config.site_name,
                show: {
                    footer: true
                }
            }
        }
        ]
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
                layout: DefaultLayout,
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
                    name: 'Quản lý',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'Nhóm Tin'
                }],
                header: 'Danh sách nhóm tin',
                layout: MainLayout,
                role: 'admin',
                title: 'News Groups | ' + config.site_name
            }
        }]
    }, {
        path: 'informations',
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
                layout: DefaultLayout,
                role: 'admin',
                title: 'News | ' + config.site_name
            }
        }, {
            path: 'add',
            component: NewsAdd,
            name: 'admin.informations.add',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'News',
                    linkName: 'admin.informations.list',
                    linkPath: '/informations'
                }, {
                    name: 'News Add'
                }],
                header: 'News Add',
                layout: DefaultLayout,
                role: 'admin',
                title: 'News Add | ' + config.site_name
            }
        }, {
            path: 'edit/:infoId',
            component: NewsEdit,
            name: 'admin.informations.edit',
            meta: {
                auth: true,
                breadcrumbs: [{
                    name: 'Dashboard',
                    linkName: 'admin.dashboard',
                    linkPath: '/dashboard'
                }, {
                    name: 'News',
                    linkName: 'admin.informations.list',
                    linkPath: '/informations'
                }, {
                    name: 'News Edit'
                }],
                header: 'News Edit',
                layout: DefaultLayout,
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
                layout: DefaultLayout,
                role: 'admin',
                title: 'Filemanagers | ' + config.site_name
            }
        }]
    }]
}];