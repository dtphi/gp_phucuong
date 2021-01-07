<template>
    <div class="head-name" :class="{ 'head-menu-name': !header }">
        <b-dropdown variant="link" right>
            <template #button-content>
                <i class="fas fa-user mr-1"></i>
                <span>{{ user }}</span>
            </template>
            <b-dropdown-item :to="{ name: menuLink }">
                <i class="fas fa-home mr-1"></i> メインメニュー
            </b-dropdown-item>
            <b-dropdown-item @click="onLogout">
                <i class="fas fa-sign-out-alt mr-1"></i> ログアウト
            </b-dropdown-item>
        </b-dropdown>
        <span>さん</span>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: 'TheHeaderInner',
        data() {
            return {
                menuLink: '',
                header: ''
            };
        },
        computed: {
            ...mapGetters('admin.auth', [ 'admin' ]),
            ...mapGetters('representative.auth', [ 'representative' ]),
            ...mapGetters('store.auth', [ 'store' ]),
            user() {
                switch (this.$route.meta.role) {
                    case 'admin':
                        this.menuLink = 'admin.menu.main.menu';
                        return this.admin ? this.admin.name : '';
                    case 'store':
                        this.menuLink = 'store.menu.main.menu';
                        return this.store ? this.store.name : '';
                    default:
                        this.menuLink = 'representative.menu.main.menu';
                        return this.representative ? this.representative.full_name : '';
                }
            }
        },
        mounted() {
            this.header = this.$route.meta.header;
            this.onCountUnread();
        },
        methods: {
            ...mapActions('admin.auth', { adminLogout: 'logout' }),
            ...mapActions('representative.auth', { representativeLogout: 'logout' }),
            ...mapActions('representative.messages', { representativeCountUnread: 'countUnread' }),
            ...mapActions('store.auth', { storeLogout: 'logout' }),
            ...mapActions('store.messages', { storeCountUnread: 'countUnread' }),
            async onCountUnread() {
                let data = {};

                switch (this.$route.meta.role) {
                    case 'representative':
                        data = {
                            representativeId: this.representative.id,
                            senderType: 2
                        };
                        await this.representativeCountUnread(this.serialize(data));
                        break;
                    case 'store':
                        data = {
                            storeId: this.store.id,
                            senderType: 1
                        };
                        await this.storeCountUnread(this.serialize(data));
                        break;
                }
            },
            async onLogout() {
                switch (this.$route.meta.role) {
                    case 'admin':
                        await this.adminLogout();
                        await this.$router.push({ name: 'admin.auth.login' });
                        break;
                    case 'store':
                        await this.storeLogout();
                        await this.$router.push({ name: 'public.auth.login' });
                        break;
                    default:
                        await this.representativeLogout();
                        await this.$router.push({ name: 'public.auth.login' });
                        break;
                }
            },
        }
    };
</script>

<style scoped>

</style>