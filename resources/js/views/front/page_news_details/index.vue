<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>

            <main-content v-if="_isContentMain"></main-content>

            <content-bottom v-if="_isContentBottom"></content-bottom>
        </div>
    </main>
</template>

<script>
    import {
        mapGetters,
        mapActions
    } from 'vuex';
    import MainMenu from 'com@front/Common/MainMenu';
    import {
        MODULE_INFO_DETAIL
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';
    import MainContent from 'com@front/Common/MainContent';
    import ContentBottom from 'com@front/Common/ContentBottom';

    export default {
        name: 'NewsDetailPage',
        components: {
            MainMenu,
            MainContent,
            ContentBottom
        },
        data() {
            return {}
        },
        computed: {
            ...mapGetters(MODULE_INFO_DETAIL, [
                'pageLists'
            ]),
            _isContentBottom() {
                return this.$route.meta.layout_content.content_bottom;
            },
            _isContentMain() {
                return this.$route.meta.layout_content.content_main;
            },
        },
        mounted() {
            this.[GET_DETAIL]({
                slug: this.$route.params.slug
            });
        },
        methods: {
            ...mapActions(MODULE_INFO_DETAIL, [
                GET_DETAIL,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './new-detail-styles.scss';
</style>
