import AuthLayout from '../components/AuthLayout';
import StoreLayout from '../components/store/StoreLayout';
import Menu from '../components/store/menu/MainMenu';
import ChatMessages from '../components/store/messages/ChatMessages';
import ChangePassword from '../components/store/setting/ChangePassword';
import ChangeEmail from '../components/store/setting/ChangeEmail';
import CatalogList from '../components/store/catalog/CatalogList';
import PurchaseList from '../components/store/history/PurchaseList';
import PurchaseDetail from '../components/store/history/PurchaseDetail';

import { config } from '../common/config';

export default [
    {
        path: '/store',
        component: {
            render: c => c('router-view')
        },
        children: [
            {
                path: '',
                redirect: {
                    name: 'public.auth.login'
                }
            },
            {
                path: 'login',
                redirect: {
                    name: 'public.auth.login'
                }
            },
            {
                path: 'reset-password',
                redirect: {
                    name: 'public.auth.reset.password'
                }
            },
            {
                path: 'menu',
                component: Menu,
                name: 'store.menu.main.menu',
                meta: {
                    auth: true,
                    layout: AuthLayout,
                    role: 'store',
                    show: {
                        header: true,
                        footer: true
                    },
                    title: '販売店 | メインメニュー | ' + config.site_name
                }
            },
            {
                path: 'message',
                component: ChatMessages,
                name: 'store.chat.messages',
                meta: {
                    auth: true,
                    breadcrumbs: [
                        {
                            name: 'メインメニュー',
                            link: 'store.menu.main.menu'
                        },
                        {
                            name: 'メッセージ'
                        }
                    ],
                    header: 'メッセージ',
                    layout: StoreLayout,
                    role: 'store',
                    title: '販売店 | メッセージ | ' + config.site_name
                }
            },
            {
                path: 'change-password',
                component: ChangePassword,
                name: 'store.change.password',
                meta: {
                    auth: true,
                    breadcrumbs: [
                        {
                            name: 'メインメニュー',
                            link: 'store.menu.main.menu'
                        },
                        {
                            name: 'パスワードの変更'
                        }
                    ],
                    header: 'パスワードの変更',
                    layout: StoreLayout,
                    role: 'store',
                    title: '販売店 | パスワードの変更 | ' + config.site_name
                }
            },
            {
                path: 'change-email',
                component: ChangeEmail,
                name: 'store.change.email',
                meta: {
                    auth: true,
                    breadcrumbs: [
                        {
                            name: 'メインメニュー',
                            link: 'store.menu.main.menu'
                        },
                        {
                            name: 'メールアドレスの登録'
                        }
                    ],
                    header: 'メールアドレスの登録',
                    layout: StoreLayout,
                    role: 'store',
                    title: '販売店 | メールアドレスの登録 | ' + config.site_name
                }
            },
            {
                path: 'catalog-list',
                component: CatalogList,
                name: 'store.catalog.list',
                meta: {
                    auth: true,
                    breadcrumbs: [
                        {
                            name: 'メインメニュー',
                            link: 'store.menu.main.menu'
                        },
                        {
                            name: 'オンラインカタログ'
                        }
                    ],
                    header: 'オンラインカタログ',
                    layout: StoreLayout,
                    role: 'store',
                    title: '販売店 | オンラインカタログ | ' + config.site_name
                }
            },
            {
                path: 'purchase-list',
                component: {
                    render: c => c('router-view')
                },
                children: [
                    {
                        path: '',
                        component: PurchaseList,
                        name: 'store.history.purchase.list',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'store.menu.main.menu'
                                },
                                {
                                    name: '購入履歴'
                                }
                            ],
                            header: '購入履歴',
                            layout: StoreLayout,
                            role: 'store',
                            title: '販売店 | 購入履歴 | ' + config.site_name
                        }
                    },
                    {
                        path: ':id',
                        component: PurchaseDetail,
                        name: 'store.history.purchase.detail',
                        meta: {
                            auth: true,
                            breadcrumbs: [
                                {
                                    name: 'メインメニュー',
                                    link: 'store.menu.main.menu'
                                },
                                {
                                    name: '購入履歴',
                                    link: 'store.history.purchase.list'
                                },
                                {
                                    name: '再発注'
                                }
                            ],
                            header: '購入履歴',
                            layout: StoreLayout,
                            role: 'store',
                            title: '販売店 | 詳細 - 再発注 | ' + config.site_name
                        }
                    }
                ]
            }
        ]
    }
];