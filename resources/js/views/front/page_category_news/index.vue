<template>
    <main id="video" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <div style="background-color: #80808008;" :style="{backgroundColor:contentBgColor}">
                <content-top v-if="_isContentTop">
                    <template v-if="loading">
                        <loading-over-lay
                            :active.sync="loading"
                            :is-full-page="fullPage"></loading-over-lay>
                    </template>
                    
                    <div class="list-videos">
                        <the-list-category-news-item
                            class="info-list"
                            v-for="(item,idx) in infoList"
                            :info="item"
                            :key="idx"></the-list-category-news-item>
                        <template v-if="infoList.length == 0">
                            <div style="text-align: center;font-size: 30px;color: #f0f8ffc7;">
                                Nội Dung Danh Mục Chưa Có Thông Tin
                            </div>
                        </template>
                    </div>
                    <paginate></paginate>
                    <template v-slot:column_right>
                        <social-network></social-network>
                        <!--<div class="box-social">
                            <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
                        </div>-->
                        <div class="box-care mt-3">
                            <b-row class="mt-3">
                                <b-col cols="12" class="m-auto">
                                    <p class="mb-0 text-download">Tải app sách nói công giáo</p>
                                </b-col>
                                <b-col cols="12">
                                    <b-carousel
                                        id="carousel-2"
                                        :interval="4000"
                                        controls
                                        indicators
                                    >
                                        <b-carousel-slide
                                            img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                        <b-carousel-slide
                                            img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                    </b-carousel>
                                </b-col>
                            </b-row>
                        </div>
                    </template>
                </content-top>
                <main-content v-if="_isContentMain"></main-content>
                <content-bottom v-if="_isContentBottom"></content-bottom>
            </div>
        </div>
    </main>
</template>

<script>
    import {
        mapActions,
        mapState
    } from 'vuex';
    import MainMenu from 'com@front/Common/MainMenu';
    import TheListCategoryNewsItem from './components/TheListCategoryNewsItem';
    import Paginate from 'com@front/Pagination';
    import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';
    import MainContent from 'com@front/Common/MainContent';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import ContentTop from 'com@front/Common/ContentTop';
    import SocialNetwork from 'com@front/Common/SocialNetwork';
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import NewsletterRegister from 'com@front/Common/NewsletterRegister';

    export default {
        name: 'InfoListtoCategory',
        components: {
            MainMenu,
            ContentTop,
            MainContent,
            ContentBottom,
            TheListCategoryNewsItem,
            Paginate,
            SocialNetwork,
            TabInfoViewedAndPopular,
            NewsletterRegister
        },
        data() {
            return {
                fullPage: false,
                isResource: false
            }
        },
        computed: {
            ...mapState({
                contentBgColor: state => state.cfApp.setting.contentBgColor,
            }),
            ...mapState(MODULE_INFO, {
                infoList: state => state.pageLists,
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
            this.[GET_INFORMATION_LIST_TO_CATEGORY]({
                ...this.$route.params,
                renderType: 1
            });
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_INFORMATION_LIST_TO_CATEGORY,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './category-news-styles.scss';
</style>
