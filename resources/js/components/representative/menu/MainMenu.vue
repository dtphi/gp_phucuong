<template>
    <div class="container menu-container">
        <div class="row justify-content-md-center menu-block">
            <div class="col-lg-12">
                <h3 class="menu-logo">
                    <b-img src="/img/login-title.png" alt="Nittoh Mobile System"></b-img>
                </h3>
                
                <h3 class="menu-title">メインメニュー</h3>

                <div role="tablist" class="accordion">
                    <b-card class="menu-block-item" no-body>
                        <b-card-header role="tab" class="menu-block-item-header">
                            <div @click="$router.push({ name: 'representative.chat.messages' })">
                                <span class="menu-first-icon h2" :class="{ 'red-dot': unread > 0 }">
                                    <i class="fas fa-comment-dots"></i>
                                </span>
                                <h4 class="menu-block-title">メッセージ</h4>
                                <span class="menu-last-icon h3">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </div>
                        </b-card-header>
                    </b-card>

                    <b-card class="menu-block-item" no-body>
                        <b-card-header role="tab" class="menu-block-item-header">
                            <div v-b-toggle.accordion-settings>
                                <span class="menu-first-icon h2">
                                    <i class="fas fa-cog"></i>
                                </span>
                                <h4 class="menu-block-title">設定</h4>
                                <span class="menu-last-icon h3">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </div>
                        </b-card-header>
                        <b-collapse id="accordion-settings" accordion="my-accordion" role="tabpanel">
                            <b-card-body class="menu-block-item-body">
                                <ul>
                                    <li>
                                        <b-link :to="{ name: 'representative.change.email' }">メールアドレスの変更</b-link>
                                    </li>
                                    <li>
                                        <b-link :to="{ name: 'representative.change.password' }">パスワードの変更</b-link>
                                    </li>
                                </ul>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: 'MainMenu',
        computed: {
            ...mapGetters('representative.messages', [ 'unread' ])
        }
    };
</script>

<style scoped>

</style>