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
                <module-loi-chua></module-loi-chua>
                <b-row class="mt-4">
                    <b-col cols="6" class="col-mobile">
                        <div class="new mt-3">
                            <h4 class="tit-common mb-3">
                                <img :src="iconBook" alt=""> Tin giáo hội</h4>
                            <p class="info-post mb-2">
                                <img
                                    :src="iconBook" alt="">
                                <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>
                            <h4 class="tit-bg-common">
                                <span><i class="bg-orange">hot</i></span>
                                <a href="#">Chúc mừng Đức Tổng Giám Mục Leopoldo Girelli</a>
                            </h4>
                            <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                            <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>

                            <p class="mt-2">
                                <em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa...</em>
                                <a class="font-weight-bold" href="#">Xem thêm</a>
                            </p>

                            <hr>

                            <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                                <span>
                                    <i class="status bg-green">Live</i>
                                </span>
                                <span>
                                    <img :src="iconBook" alt="">
                                    <i>Điểm tin giáo hội</i>
                                </span>
                                <span>
                                    <img :src="iconBook" alt="">
                                    <i>Thanh Thúy</i>
                                </span>
                            </a>
                        </div>
                    </b-col>

                    <b-col cols="6" class="col-mobile">
                        <div class="new mt-3">
                            <h4 class="tit-common mb-3"><img :src="iconBook" alt=""> Tin giáo hội việt nam</h4>
                            <p class="info-post mb-2">
                                <img :src="iconBook" alt="">
                                <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>
                            <h4 class="tit-bg-common">
                                <span><i class="bg-green">live</i></span>
                                <a href="#">Chúc mừng Đức Tổng Giám Mục Leopoldo Girelli</a>
                            </h4>
                            <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                            <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>

                            <p class="mt-2">
                                <em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa...</em>
                                <a class="font-weight-bold" href="#">Xem thêm</a>
                            </p>

                            <hr>

                            <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                                <span>
                                    <i class="status bg-red">hot</i>
                                </span>
                                <span>
                                    <img :src="iconBook" alt="">
                                    <i>Điểm tin giáo hội</i>
                                </span>
                                <span>
                                    <img :src="iconBook" alt="">
                                    <i>Thanh Thúy</i>
                                </span>
                            </a>
                        </div>
                    </b-col>
                </b-row>
                <div class="mt-4 new-diocese">
                    <h4 class="tit-common mb-3">
                        <img :src="iconBook" alt=""> Tin giáo phận
                        <a href="#" class="view-all">View all</a>
                    </h4>
                    <b-row>
                        <b-col cols="7" class="col-mobile">
                            <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                            <h4 class="tit-bg-common mt-2">
                                <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                            </h4>
                            <p class="info-post">
                                <img :src="iconBook" alt="">
                                <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>
                        </b-col>
                        <b-col cols="5" class="col-r col-mobile">
                            <a class="d-block" href="#"><img class="img" :src="imgFooter" alt=""></a>
                            <h4 class="tit-bg-common mt-2">
                                <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                            </h4>
                            <p class="info-post">
                                <img :src="iconBook" alt="">
                                <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>

                            <hr class="my-2">

                            <h4 class="tit-bg-common">
                                <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                            </h4>
                            <p class="info-post">
                                <img :src="iconBook" alt="">
                                <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>

                            <hr class="my-2">

                            <h4 class="tit-bg-common">
                                <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                            </h4>
                            <p class="info-post">
                                <img :src="iconBook" alt="">
                                <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                <b-icon class="alarm" icon="alarm"></b-icon>
                                <span>12/03/2021</span>
                            </p>
                        </b-col>
                    </b-row>
                </div>
                <module-van-kien></module-van-kien>
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
    import ModuleLoiChua from 'v@front/modules/loi_chuas';
    import ModuleVanKien from 'v@front/modules/van_kiens';
    import ImgFooter from 'v@front/assets/img/image_footer.jpg';
    import IconBook from 'v@front/assets/img/icon-book.png';

    export default {
        name: 'InfoPage',
        components: {
            MainMenu,
            TabInfoViewedAndPopular,
            ContentTop,
            ContentBottom,
            ModuleLoiChua,
            ModuleVanKien
        },
        data() {
            return {
                isContentBottom: true,
                fullPage: false,
                imgFooter: ImgFooter,
                iconBook: IconBook,
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
