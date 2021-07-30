<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <div style="background-color: #80808008;">
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
                    <div class="header-linh-muc w-100">
                        <span class="d-block line-header"></span>
                        <div class="box-header">
                            <div class="row">
                                <div class="col-mobile col-3">
                                    <span class="d-block img-header">
                                        <img class="img rounded-circle" src="http://haydesachnoipodcast.com/storage/.tmb/thumb_730x410/Image/NewPicture/Tin-Giao-Phan/Thu-Keu-Goi.jpg" alt="">
                                    </span>
                                </div>
                                <div class="col-mobile col-9 text-center text-header">
                                    <h2>Trang thông tin linh mục</h2>
                                    <h5>Giáo phận phú cường</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-linh-muc w-100 mt-3">
                        <div class="row">
                            <div class="col-mobile col-3">
                                <div class="row">
                                    <p class="col-4 text-uppercase">Linh mục</p>
                                    <div class="col-8 level-text">
                                        <p class="text-uppercase">Tên thánh</p>
                                        <p class="text-uppercase">Họ và tên cha</p>
                                        <p class="text-uppercase">Chức vụ hiện tại</p>
                                    </div>
                                </div>

                                <div class="bi-tich p-4 mt-3">
                                    <h4 class="text-uppercase text-white text-center mb-3">Bí tích</h4>
                                    <a class="d-block text-white" href="#">Bí tích Rửa Tội</a>
                                    <a class="d-block text-white" href="#">Bí tích Thêm sức</a>
                                    <a class="d-block text-white" href="#">Bí tích Truyền Chức</a>
                                    <a class="d-block text-white" href="#">1. Phó Tế</a>
                                    <a class="d-block text-white" href="#">2. Linh Mục</a>
                                    <a class="d-block text-white" href="#">3. Giám Mục</a>
                                </div>
                            </div>
                            <div class="col-mobile col-9">
                                <span class="d-block avatar-img mt-3">
                                    <img class="img" src="https://giaophanphucuong.org/Image/Picture/Logo/logo%20for%20web.png" alt="">
                                </span>
                                <div class="info-personal mt-5">
                                    <h4 class="text-uppercase">Thông tin cá nhân</h4>
                                    <p class="row">
                                        <span class="col-mobile col-4">Ngày sinh: </span>
                                        <span class="col-mobile col-4">Tại: </span>
                                    </p>
                                    <p class="row">
                                        <span class="col-mobile col-4">Giáo xứ: </span>
                                        <span class="col-mobile col-4">Giáo phận: </span>
                                    </p>
                                    <p>Tên cha: </p>
                                    <p>Tên mẹ: </p>
                                    <p>CMND: </p>
                                    <p class="row">
                                        <span class="col-mobile col-4">Ngày cấp: </span>
                                        <span class="col-mobile col-4">Nơi cấp: </span>
                                    </p>
                                </div>

                                <div class="maxim text-center">
                                    <h4 class="tit-maxim">Châm ngôn đời linh mục</h4>
                                </div>
                            </div>
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
