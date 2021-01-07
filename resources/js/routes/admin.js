import AdminLayout from '../components/admin/AdminLayout';
import AuthLayout from '../components/AuthLayout';
import Login from '../components/admin/auth/Login';
import Menu from '../components/admin/menu/MainMenu';
import RepresentativesCreate from '../components/admin/representatives/RepresentativesCreate';
import RepresentativesList from '../components/admin/representatives/RepresentativesList';
import RepresentativesUpdate from '../components/admin/representatives/RepresentativesUpdate';
import StoresCreate from '../components/admin/stores/StoresCreate';
import StoresList from '../components/admin/stores/StoresList';
import StoresShowMessage from '../components/admin/stores/StoresShowMessage';
import StoresUpdate from '../components/admin/stores/StoresUpdate';

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
                path: 'menu',
                component: Menu,
                name: 'admin.menu.main.menu',
                meta: {
                    auth: true,
                    layout: AuthLayout,
                    role: 'admin',
                    show: {
                        header: true,
                        footer: true
                    },
                    title: '管理者 | メインメニュー | ' + config.site_name
                }
            },
            {
                path: 'sales-representatives',
                component: {
                    render: c => c('router-view')
                },
                children: [
                    {
                        path: '',
                        component: RepresentativesList,
                        name: 'admin.representatives.list',
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
                            layout: AdminLayout,
                            role: 'admin',
                            title: '管理者 | 営業担当者 | ' + config.site_name
                        }
                    },
                    {
                        path: 'create',
                        component: RepresentativesCreate,
                        name: 'admin.representatives.create',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'admin.menu.main.menu'
                                },
                                {
                                    name: '営業担当者',
                                    link: 'admin.representatives.list'
                                },
                                {
                                    name: '新規登録'
                                }
                            ],
                            header: '営業担当者',
                            layout: AdminLayout,
                            role: 'admin',
                            title: '管理者 | 新規登録 | ' + config.site_name
                        }
                    },
                    {
                        path: ':id',
                        component: RepresentativesUpdate,
                        name: 'admin.representatives.update',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'admin.menu.main.menu'
                                },
                                {
                                    name: '営業担当者',
                                    link: 'admin.representatives.list'
                                },
                                {
                                    name: '詳細'
                                }
                            ],
                            header: '営業担当者',
                            layout: AdminLayout,
                            role: 'admin',
                            title: '管理者 | 詳細 | ' + config.site_name
                        }
                    }
                ]
            },
            {
                path: 'stores',
                component: {
                    render: c => c('router-view')
                },
                children: [
                    {
                        path: '',
                        component: StoresList,
                        name: 'admin.stores.list',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'admin.menu.main.menu'
                                },
                                {
                                    name: '販売店'
                                }
                            ],
                            header: '販売店',
                            layout: AdminLayout,
                            role: 'admin',
                            title: '管理者 | 販売店 | ' + config.site_name
                        }
                    },
                    {
                        path: 'create',
                        component: StoresCreate,
                        name: 'admin.stores.create',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'admin.menu.main.menu'
                                },
                                {
                                    name: '販売店',
                                    link: 'admin.stores.list'
                                },
                                {
                                    name: '新規登録'
                                }
                            ],
                            header: '販売店',
                            layout: AdminLayout,
                            role: 'admin',
                            title: '管理者 | 新規登録 | ' + config.site_name
                        }
                    },
                    {
                        path: ':id',
                        component: StoresUpdate,
                        name: 'admin.stores.update',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'admin.menu.main.menu'
                                },
                                {
                                    name: '販売店',
                                    link: 'admin.stores.list'
                                },
                                {
                                    name: '詳細'
                                }
                            ],
                            header: '販売店',
                            layout: AdminLayout,
                            role: 'admin',
                            title: '管理者 | 詳細 | ' + config.site_name
                        }
                    },
                    {
                        path: ':id/messages',
                        component: StoresShowMessage,
                        name: 'admin.stores.show.messages',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'admin.menu.main.menu'
                                },
                                {
                                    name: '販売店',
                                    link: 'admin.stores.list'
                                },
                                {
                                    name: '詳細',
                                    link: 'admin.stores.update'
                                },
                                {
                                    name: 'メッセージ'
                                }
                            ],
                            header: '販売店',
                            layout: AdminLayout,
                            role: 'admin',
                            title: '管理者 | メッセージ | ' + config.site_name
                        }
                    }
                ]
            }
        ]
    }
];