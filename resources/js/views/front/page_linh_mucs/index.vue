<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <div style="background-color: #80808008;" :style="{backgroundColor:contentBgColor}">
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
                        <div class="box-care mt-3">
                            <b-row class="mt-3">
                                <b-col cols="12" class="m-auto">
                                    <p class="mb-0 text-download" style="padding: 4px 0">Tải app sách nói công giáo</p>
                                </b-col>
                                <b-col cols="12">
                                    <b-carousel
                                        id="carousel-2"
                                        :interval="4000"
                                        style="cursor: pointer;height:150px"
                                        controls
                                        indicators
                                    >
                                        <b-carousel-slide>
                                                <template v-slot:img>
                                                    <img
                                                        class="d-block img-fluid w-100"
                                                        style="width:100%; height:150px !important"
                                                        :src="imgCarousel">
                                                </template>
                                        </b-carousel-slide>
                                        <b-carousel-slide>
                                            <template v-slot:img>
                                                    <img
                                                        class="d-block img-fluid w-100"
                                                        style="width:100%; height:150px !important"
                                                        :src="imgCarousel">
                                                </template>
                                        </b-carousel-slide>
                                    </b-carousel>
                                </b-col>
                            </b-row>
                        </div>
                    </template>
                </content-top>
                <main-content v-if="_isContentMain">
                    <template v-slot:before>
                        <!-- Html linh mục detail -->
                        <div class="list-danh-muc w-100">
                            <h2 class="title-linh-muc text-center">Danh sách linh mục đoàn giáo phận phú cường <hr class="line-linh-muc"></h2>
                            <div class="tab-linh-muc w-100">
                                <b-tabs content-class="mt-3" fill>
                                    <b-tab title="Lọc theo chức vụ / Giáo hạt" active>
                                        <div class="list-linh-muc">
                                            <div class="row row-linh-muc">
                                                <div class="col-mobile col-2">
                                                    <a class="avatar" href="#"><img class="img" src="https://donghanhonline.com/wp-content/uploads/2020/08/linh-muc.jpg" alt=""></a>
                                                </div>
                                                <div class="col-mobile col-10 content">
                                                    <h4 class="tit"><a href="#">Linh mục Gioan Baotixita Nguyễn Văn A</a></h4>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span>Chức vụ: Chánh xứ</span>
                                                            <span>Nơi phục vụ: Gx. Tân Châu</span>
                                                            <span>Giáo hạt: Bình Long</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span>Năm sinh: 25/11/1982</span>
                                                            <span>Chịu chức: 28/11/2014</span>
                                                            <span>Địa chỉ: 104 Lạc Long Quân...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row row-linh-muc">
                                                <div class="col-mobile col-2">
                                                    <a class="avatar" href="#"><img class="img" src="https://donghanhonline.com/wp-content/uploads/2020/08/linh-muc.jpg" alt=""></a>
                                                </div>
                                                <div class="col-mobile col-10 content">
                                                    <h4 class="tit"><a href="#">Linh mục Gioan Baotixita Nguyễn Văn A</a></h4>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <span>Chức vụ: Chánh xứ</span>
                                                            <span>Nơi phục vụ: Gx. Tân Châu</span>
                                                            <span>Giáo hạt: Bình Long</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span>Năm sinh: 25/11/1982</span>
                                                            <span>Chịu chức: 28/11/2014</span>
                                                            <span>Địa chỉ: 104 Lạc Long Quân...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                    <b-tab title="Tất cả">
                                        <p>I'm the first tab</p>
                                    </b-tab>
                                </b-tabs>
                            </div>
                        </div>
                    </template>
                </main-content>
                <content-bottom v-if="_isContentBottom">
                </content-bottom>
            </div>
        </div>
    </main>
</template>

<script>
    import {
        mapState,
        mapActions
    } from 'vuex';
    import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';
    import MainMenu from 'com@front/Common/MainMenu';
    import ContentTop from 'com@front/Common/ContentTop';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import SocialNetwork from 'com@front/Common/SocialNetwork'; 
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import NewsletterRegister from 'com@front/Common/NewsletterRegister';
    import MainContent from 'com@front/Common/MainContent';
    import ModulePageBannerList from 'v@front/modules/page_banner_lists';

    export default {
        name: 'InfoPage',
        components: {
            MainMenu,
            TabInfoViewedAndPopular,
            ContentTop,
            ContentBottom,
            SocialNetwork,
            NewsletterRegister,
            MainContent,
            ModulePageBannerList
        },
        data() {
            return {
                isContentBottom: true,
                fullPage: false,
                isTopBottomBoth: false,
                imgCarousel: 'https://picsum.photos/1024/480/?image=58'
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
            this.[GET_INFORMATION_LIST_TO_CATEGORY](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_INFORMATION_LIST_TO_CATEGORY,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './styles.scss';
</style>
