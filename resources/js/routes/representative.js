import AuthLayout from '../components/AuthLayout';
import RepresentativeLayout from '../components/representative/RepresentativeLayout';
import Menu from '../components/representative/menu/MainMenu';
import ChatMessages from '../components/representative/messages/ChatMessages';
import ChangePassword from '../components/representative/setting/ChangePassword';
import ChangeEmail from '../components/representative/setting/ChangeEmail';

import { config } from '../common/config';

export default [
    {
        path: '/sale-representative',
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
                name: 'representative.menu.main.menu',
                meta: {
                    auth: true,
                    layout: AuthLayout,
                    role: 'representative',
                    show: {
                        header: true,
                        footer: true
                    },
                    title: '営業担当者 | メインメニュー | ' + config.site_name
                }
            },
            {
                path: 'message',
                component: ChatMessages,
                name: 'representative.chat.messages',
                meta: {
                    auth: true,
                    breadcrumbs: [
                        {
                            name: 'メインメニュー',
                            link: 'representative.menu.main.menu'
                        },
                        {
                            name: 'メッセージ'
                        }
                    ],
                    header: 'メッセージ',
                    layout: RepresentativeLayout,
                    role: 'representative',
                    title: '営業担当者 | メッセージ | ' + config.site_name
                }
            },
            {
                path: 'change-password',
                component: ChangePassword,
                name: 'representative.change.password',
                meta: {
                    auth: true,
                    breadcrumbs: [
                        {
                            name: 'メインメニュー',
                            link: 'representative.menu.main.menu'
                        },
                        {
                            name: 'パスワードの変更'
                        }
                    ],
                    header: 'パスワードの変更',
                    layout: RepresentativeLayout,
                    role: 'representative',
                    title: '営業担当者 | パスワードの変更 | ' + config.site_name
                }
            },
            {
                path: 'change-email',
                component: ChangeEmail,
                name: 'representative.change.email',
                meta: {
                    auth: true,
                    breadcrumbs: [
                        {
                            name: 'メインメニュー',
                            link: 'representative.menu.main.menu'
                        },
                        {
                            name: 'メールアドレスの変更'
                        }
                    ],
                    header: 'メールアドレスの変更',
                    layout: RepresentativeLayout,
                    role: 'representative',
                    title: '営業担当者 | メールアドレスの変更 | ' + config.site_name
                }
            }
        ]
    }
];