<template>
    <li class="nav-item">
        <a
            @click="_logout()"
            href="javascript:void(0)"
            class="nav-link"
            title="Logout Admin">
            <font-awesome-icon icon="power-off" size="xs"/>
            Logout
        </a>
    </li>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'LogoutSideBar',
        computed: {
            ...mapGetters('auth', ['authenticated'])
        },
        methods: {
            ...mapActions({
                signOut: 'auth/signOut',
                redirectLogout: 'auth/redirectLogoutSuccess'
            }),
            async _submit() {
                await this.signOut();
                if (!this.authenticated) {
                    this.redirectLogout();
                }
            },
            _logout() {
                this._submit();
            }
        }
    };
</script>
