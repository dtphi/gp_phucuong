<template>
    <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
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
                        <h4 class="tit-common clr-blue">Quan tâm</h4>

                        <p class="font-weight-bold">Đăng ký để nhận tin mỗi ngày</p>
                        <input id="email" type="text" placeholder="Enter your e-mail address">
                        <input class="btn mt-2" type="button" value="Subscribe">

                        <b-row class="mt-3">
                            <b-col cols="5" class="m-auto">
                                <p class="mb-0 text-download">Tải app sách nói công giáo</p>
                            </b-col>
                            <b-col cols="7">
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
            
            <content-bottom v-if="_isContentBottom">
                <b-row class="mt-4">
                    <module-tin-giao-hoi></module-tin-giao-hoi>
                    <module-tin-giao-hoi-viet-nam></module-tin-giao-hoi-viet-nam>
                </b-row>
            </content-bottom>
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
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import ContentTop from 'com@front/Common/ContentTop';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import ModuleTinGiaoHoi from 'v@front/modules/tin_giao_hois';
    import ModuleTinGiaoHoiVietNam from 'v@front/modules/tin_giao_hoi_viet_nams';
    import SocialNetwork from './components/TheSocialNetwork';

    export default {
        name: 'InfoPage',
        components: {
            MainMenu,
            TabInfoViewedAndPopular,
            ContentTop,
            ContentBottom,
            ModuleTinGiaoHoi,
            ModuleTinGiaoHoiVietNam,
            SocialNetwork
        },
        data() {
            return {
                isContentBottom: true,
                fullPage: false,
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
    @import './news-styles.scss';
</style>
