<template>
    <nav id="sidebar-menu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
        <template v-if="$router.currentRoute.meta.role === 'admin'">
            <b-link :to="{ name: 'admin.menu.main.menu' }" class="m-0 text-center d-none d-md-block logo-side">
                <b-img src="/img/logo.png" class="img-fluid"></b-img>
            </b-link>

            <div class="sidebar-sticky pt-0">
                <ul class="nav flex-column">
                    <router-link :to="{ name: 'admin.representatives.list' }" v-slot="{ href, isActive }">
                        <li class="nav-item" :class="{ active: isActive }">
                            <b-link :href="href" class="nav-link">
                                <span class="menu-first-icon">
                                    <i class="fas fa-user-tie"></i>
                                </span> 営業担当者
                            </b-link>
                        </li>
                    </router-link>

                    <router-link :to="{ name: 'admin.stores.list' }" v-slot="{ href, isActive }">
                        <li class="nav-item" :class="{ active: isActive }">
                            <b-link :href="href" class="nav-link">
                                <span class="menu-first-icon">
                                    <i class="fas fa-store"></i>
                                </span> 販売店
                            </b-link>
                        </li>
                    </router-link>

                    <router-link :to="{ name: 'admin.newsgroups.list' }" v-slot="{ href, isActive }">
                        <li class="nav-item" :class="{ active: isActive }">
                            <b-link :href="href" class="nav-link">
                                <span class="menu-first-icon">
                                    <i class="fas fa-store"></i>
                                </span> News Group
                            </b-link>
                        </li>
                    </router-link>
                </ul>
            </div>
        </template>

        <template v-if="$router.currentRoute.meta.role === 'store'">
            <b-link :to="{ name: 'store.menu.main.menu' }" class="m-0 text-center d-none d-md-block logo-side">
                <b-img src="/img/logo.png" class="img-fluid"></b-img>
            </b-link>

            <div class="sidebar-sticky pt-0">
                <ul class="nav flex-column">
                    <router-link :to="{ name: 'store.chat.messages' }" v-slot="{ href, isActive }">
                        <li class="nav-item" :class="{ active: isActive }">
                            <b-link :href="href" class="nav-link">
                                <span class="menu-first-icon" :class="{ 'red-dot': storeUnread > 0 }">
                                    <i class="fas fa-comment-dots"></i>
                                </span> メッセージ
                            </b-link>
                        </li>
                    </router-link>

                    <router-link :to="{ name: 'store.history.purchase.list' }" v-slot="{ href, isActive }">
                        <li class="nav-item" :class="{ active: isActive }">
                            <b-link :href="href" class="nav-link">
                                <span class="menu-first-icon">
                                    <i class="fas fa-list"></i>
                                </span> 購入履歴
                            </b-link>
                        </li>
                    </router-link>

                    <router-link :to="{ name: 'store.catalog.list' }" v-slot="{ href, isActive }">
                        <li class="nav-item" :class="{ active: isActive }">
                            <b-link :href="href" class="nav-link">
                                <span class="menu-first-icon">
                                    <i class="fas fa-bookmark"></i>
                                </span> オンラインカタログ
                            </b-link>
                        </li>
                    </router-link>

                    <li class="nav-item" :class="{ active: isSettingsLink }">
                        <b-link class="nav-link" v-b-toggle.collapse-1>
                            <span class="menu-first-icon">
                                <i class="fas fa-cog"></i>
                            </span> 設定
                            <span class="menu-last-icon h3">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </b-link>

                        <b-collapse id="collapse-1">
                            <ul class="nav-sub-link">
                                <router-link :to="{ name: 'store.change.email' }" v-slot="{ href, isActive }">
                                    <li :class="{ active: isActive }">
                                        <b-link :href="href" class="nav-link">
                                            <span class="menu-first-icon"></span> メールアドレスの登録
                                        </b-link>
                                    </li>
                                </router-link>

                                <router-link :to="{ name: 'store.change.password' }" v-slot="{ href, isActive }">
                                    <li :class="{ active: isActive }">
                                        <b-link :href="href" class="nav-link">
                                            <span class="menu-first-icon"></span> パスワードの変更
                                        </b-link>
                                    </li>
                                </router-link>
                            </ul>
                        </b-collapse>
                    </li>
                </ul>
            </div>
        </template>

        <template v-if="$router.currentRoute.meta.role === 'representative'">
            <b-link :to="{ name: 'representative.menu.main.menu' }" class="m-0 text-center d-none d-md-block logo-side">
                <b-img src="/img/logo.png" class="img-fluid"></b-img>
            </b-link>

            <div class="sidebar-sticky pt-0">
                <ul class="nav flex-column">
                    <router-link :to="{ name: 'representative.chat.messages' }" v-slot="{ href, isActive }">
                        <li class="nav-item" :class="{ active: isActive }">
                            <b-link :href="href" class="nav-link">
                                <span class="menu-first-icon" :class="{ 'red-dot': representativeUnread > 0 }">
                                    <i class="fas fa-comment-dots"></i>
                                </span> メッセージ
                            </b-link>
                        </li>
                    </router-link>

                    <li class="nav-item" :class="{ active: isSettingsLink }">
                        <b-link class="nav-link" v-b-toggle.collapse-1>
                            <span class="menu-first-icon">
                                <i class="fas fa-cog"></i>
                            </span> 設定
                            <span class="menu-last-icon h3">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </b-link>

                        <b-collapse id="collapse-1">
                            <ul class="nav-sub-link">
                                <router-link :to="{ name: 'representative.change.email' }" v-slot="{ href, isActive }">
                                    <li :class="{ active: isActive }">
                                        <b-link :href="href" class="nav-link">
                                            <span class="menu-first-icon"></span> メールアドレスの変更
                                        </b-link>
                                    </li>
                                </router-link>

                                <router-link :to="{ name: 'representative.change.password' }" v-slot="{ href, isActive }">
                                    <li :class="{ active: isActive }">
                                        <b-link :href="href" class="nav-link">
                                            <span class="menu-first-icon"></span> パスワードの変更
                                        </b-link>
                                    </li>
                                </router-link>
                            </ul>
                        </b-collapse>
                    </li>
                </ul>
            </div>
        </template>
    </nav>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: 'TheSidebar',
        computed: {
            ...mapGetters('representative.messages', { representativeUnread: 'unread' }),
            ...mapGetters('store.messages', { storeUnread: 'unread' }),
            isSettingsLink() {
                return this.$route.name === 'store.change.email' || this.$route.name === 'store.change.password' || this.$route.name === 'representative.change.email' || this.$route.name === 'representative.change.password';
            }
        }
    };
</script>

<style scoped>

</style>