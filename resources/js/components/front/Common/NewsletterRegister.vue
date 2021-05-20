<template>
    <div id="news-letter-register-component">
        <h4 class="tit-common clr-blue">Quan tâm</h4>

        <p class="font-weight-bold">Đăng ký để nhận tin mỗi ngày</p>
        <input id="email" type="text" v-model="subscribe.email" placeholder="Enter your e-mail address">
        <input class="btn mt-2" type="button" value="Subscribe" @click="_submitRegistry()">
    </div>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import {
        MODULE_SUBSCRIBE
    } from '@app/stores/front/types/module-types';
    import {
        ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER
    } from '@app/stores/front/types/action-types';

    export default {
        name: 'NewsletterRegister',
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters(MODULE_SUBSCRIBE, [
                'subscribe'
            ]),
        },
        methods: {
            ...mapActions(MODULE_SUBSCRIBE, [
                ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER
            ]),
            _submitRegistry() {
                this.[ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER](this.subscribe);
            }
        }
    }
</script>
