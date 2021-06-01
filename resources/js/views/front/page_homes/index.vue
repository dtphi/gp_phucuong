<template>
    <main id="homepage" class="py-2">
        <div class="container">
            <main-menu 
                :layout-id="_layoutId"></main-menu>
            <content-top v-if="_isContentTop">
                <template v-if="loading">
                    <loading-over-lay
                        :active.sync="loading"
                        :is-full-page="fullPage"></loading-over-lay>
                </template>
                <template v-slot:column_right>
                    <social-network></social-network>
                    <div class="box-social">
                        <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
                    </div>
                </template>
            </content-top>

            <div class="list-home mt-4 mb-3">
                <template v-if="loading">
                    <loading-over-lay
                        :active.sync="loading"
                        :is-full-page="fullPage"></loading-over-lay>
                </template>
                <figure-item-page 
                    v-for="(item, idx) in pageLists" 
                    :key="idx" 
                    :page-item="item"></figure-item-page>
            </div>
        </div>
    </main>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import MainMenu from 'com@front/Common/MainMenu';
    import FigureItemPage from './components/TheItemPage';
    import {
        MODULE_HOME
    } from '@app/stores/front/types/module-types';
    import {
        GET_LISTS
    } from '@app/stores/front/types/action-types';
    import ContentTop from 'com@front/Common/ContentTop';
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import SocialNetwork from 'com@front/Common/SocialNetwork';

    const fnIsObject = (obj) => {
        if (typeof obj !== "undefined"
            && typeof obj === "object"
            && Object.keys(obj).length) {
            return true;
        }

        return false;
    }

    export default {
        name: 'HomePage',
        components: {
            FigureItemPage,
            MainMenu,
            ContentTop,
            SocialNetwork,
            TabInfoViewedAndPopular
        },
        data() {
            return {
                layoutId: 1,
                fullPage: false,
            }
        },
        computed: {
            /*
            map return Promise().
            ...mapActions(MODULE_HOME, [
                GET_LISTS
            ]),*/
            ...mapState({
                pages: state => state.cfApp.setting.pages
            }),
            ...mapGetters(MODULE_HOME, [
                'pageLists',
                'loading'
            ]),
            _layoutId() {
                if (fnIsObject(this.pages)) {
                    return this.pages.home.id;
                }

                return this.layoutId;
            },
            _isContentTop() {
                return this.$route.meta.layout_content.content_top;
            },
        },
        methods: {
            ...mapActions(MODULE_HOME, [
                GET_LISTS
            ]),
        },
        mounted() {
            this.[GET_LISTS](this.$route.params);
        }
    }
</script>

<style lang="scss">
    @import './home-style.scss';
</style>
