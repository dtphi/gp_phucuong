import AuthLayout from '../components/AuthLayout';
import Login from '../components/public/auth/Login';
import ResetPassword from '../components/public/auth/ResetPassword';

import { config } from '../common/config';

export default [
    {
        path: '',
        component: Login,
        name: 'public.auth.login',
        meta: {
            layout: AuthLayout,
            role: 'representative',
            show: {
                footer: true
            },
            title: 'ログイン | ' + config.site_name
        }
    },
    {
        path: '/login',
        redirect: { name: 'public.auth.login' }
    },
    {
        path: '/reset-password',
        component: ResetPassword,
        name: 'public.auth.reset.password',
        meta: {
            layout: AuthLayout,
            role: 'representative',
            show: {
                footer: true
            },
            title: 'パスワード再発行 | ' + config.site_name
        }
    }
];