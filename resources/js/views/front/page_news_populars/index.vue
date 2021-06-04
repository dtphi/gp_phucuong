<template>
    <main id="video" class="py-2">
        <div class="container">
            <main-menu></main-menu>

            <div style="background-color: #80808008;">
                <content-top v-if="_isContentTop">
                    <template v-if="loading">
                        <loading-over-lay
                            :active.sync="loading"
                            :is-full-page="fullPage"></loading-over-lay>
                    </template>
                    <paginate></paginate>
                    <div class="list-videos">
                        <the-category-news-item 
                            class="figure"
                            v-for="(item,idx) in infoList"
                            :info="item"
                            :key="idx"></the-category-news-item>
                    </div>
                </content-top>
                <main-content v-if="_isContentMain"></main-content>
                <content-bottom v-if="_isContentBottom"></content-bottom>
            </div>
        </div>
    </main>
</template>

<script>
    import {
        mapGetters,
        mapActions,
        mapState
    } from 'vuex';
    import MainMenu from 'com@front/Common/MainMenu';
    import TheCategoryNewsItem from './components/TheCategoryNewsItem';
    import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_POPULAR_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';
    import MainContent from 'com@front/Common/MainContent';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import ContentTop from 'com@front/Common/ContentTop';
    import Paginate from 'com@front/Pagination';

    export default {
        name: 'InfoListtoCategory',
        components: {
            MainMenu,
            ContentTop,
            MainContent,
            ContentBottom,
            TheCategoryNewsItem,
            Paginate
        },
        data() {
            return {
                fullPage: false,
                isResource: false
            }
        },
        computed: {
            ...mapState(MODULE_INFO, {
                infoList: state => state.infoPopularList,
                loading: state => state.loading
            }),
            _isContentTop() {
                return this.$route.meta.layout_content.content_top;
            },

            _isContentBottom() {
                return this.$route.meta.layout_content.content_bottom;
            },
            _isContentMain() {
                return this.$route.meta.layout_content.content_main;
            },
        },
        mounted() {
            this.[GET_POPULAR_INFORMATION_LIST_TO_CATEGORY](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_POPULAR_INFORMATION_LIST_TO_CATEGORY,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './category-news-styles.scss';
</style>
