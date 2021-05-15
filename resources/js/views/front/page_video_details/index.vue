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
                <video-data-detail></video-data-detail>
                <template v-slot:column_right>
                    <div class="box-social">
                        <h4 class="tit-common clr-blue">Mạng xã hội</h4>
                        <div class="list-icon">
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                        </div>
                    </div>
                    <div class="box-social">
                        <tab-info-viewed-and-popular></tab-info-viewed-and-popular>
                    </div>
                </template>
            </content-top>

            <main-content v-if="_isContentMain">
                
            </main-content>
            <div class="mt-4 new-related">
                    <h4 class="tit-common clr-blue mb-3">Tin liên quan</h4>
                    <b-row>
                        <b-col class="col-mobile" cols="4" v-for="(item, index) in 6" :key="index">
                            <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                            <h4 class="tit-bg-common mt-2">
                                <a class="pl-0" href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                            </h4>
                            <p class="info-post">
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>
                        </b-col>
                    </b-row>
                </div>
                <div class="mt-2 mb-3 new-care">
                    <h4 class="tit-common clr-blue mb-3">Có thể bạn quan tâm</h4>
                    <div class="list-new">
                        <a class="d-block mb-2" href="#" v-for="(item, index) in 10" :key="index">
                            <span><b-icon class="arrow-right-circle-fill" icon="arrow-right-circle-fill"></b-icon></span>
                            <span class="mr-2">Giáo Xứ Rạch Kiến Mừng Đón Giáng Sinh</span>
                            <span><b-icon class="alarm" icon="alarm"></b-icon> 27/12/2019</span>
                        </a>
                    </div>
                </div>

            <content-bottom v-if="_isContentBottom"></content-bottom>
        </div>
    </main>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';
    import MainMenu from 'com@front/Common/MainMenu';
    import {
        MODULE_VIDEO_DETAIL
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL
    } from '@app/stores/front/types/action-types';
    import ContentTop from 'com@front/Common/ContentTop';
    import MainContent from 'com@front/Common/MainContent';
    import ContentBottom from 'com@front/Common/ContentBottom';
    import VideoDataDetail from 'com@front/Common/VideoDetail';
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';

    export default {
        name: 'NewsDetailPage',
        components: {
            MainMenu,
            ContentTop,
            MainContent,
            ContentBottom,
            VideoDataDetail,
            TabInfoViewedAndPopular,
        },
        data() {
            return {
                imgFooter: ImgFooter,
                fullPage: false,
            }
        },
        computed: {
            ...mapState(MODULE_VIDEO_DETAIL, {
                loading: state => state.loading
            }),
            ...mapGetters(MODULE_VIDEO_DETAIL, [
                'pageLists'
            ]),
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
            this.[GET_DETAIL]({
                slug: this.$route.params.slug
            });
        },
        methods: {
            ...mapActions(MODULE_VIDEO_DETAIL, [
                GET_DETAIL,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './video-styles.scss';
</style>
