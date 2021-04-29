<template>
  <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <b-row class="my-3">
                <b-col cols="8" class="col-mobile">
                    <div class="new-detail">
                        <h4 class="tit-detail">{{pageLists.name}}</h4>
                        <p>
                            <b-icon class="alarm" icon="alarm"></b-icon>
                            <span>{{pageLists.date_available}}</span>
                        </p>

                        <p>{{pageLists.sort_description}}</p>

                        <hr>

                        <div class="text-detail" v-html="pageLists.description"></div>

                        <hr>
                    </div>

                    <div class="mt-4 new-related">
                        <h4 class="tit-common clr-blue mb-3">Tin liên quan</h4>
                        <b-row>
                            <b-col class="col-mobile" cols="4" v-for="(item, index) in 6" :key="index">
                                <a class="d-block" href="#"><img class="img" src="../assets/img/image_footer.jpg" alt=""></a>
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
                </b-col>

                <b-col class="highlights col-mobile" cols="4">
                    <div class="box-social">
                        <h4 class="tit-common clr-blue">Mạng xã hội</h4>
                        <div class="list-icon">
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                        </div>

                        <b-card no-body class="mt-3">
                            <b-tabs card>
                                <b-tab title="Bài mới" active>
                                    <b-card-text>
                                        <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                                            <span>
                                                <i class="status bg-blue">Live</i>
                                            </span>
                                            <span>
                                                <img src="../assets/img/icon-book.png" alt="">
                                                <i>Điểm tin giáo hội</i>
                                            </span>
                                            <span>
                                                <img src="../assets/img/icon-book.png" alt="">
                                                <i>Thanh Thúy</i>
                                            </span>
                                        </a>
                                    </b-card-text>
                                </b-tab>
                                <b-tab title="Xem nhiều">
                                    <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                                        <span>
                                            <i class="status bg-orange">Hot</i>
                                        </span>
                                        <span>
                                            <img src="../assets/img/icon-book.png" alt="">
                                            <i>Điểm tin giáo hội</i>
                                        </span>
                                        <span>
                                            <img src="../assets/img/icon-book.png" alt="">
                                            <i>Thanh Thúy</i>
                                        </span>
                                    </a>
                                </b-tab>
                            </b-tabs>
                        </b-card>
                    </div>
                    
                    <div class="box-care my-3">
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
                                    <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                    <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                </b-carousel>
                            </b-col>
                        </b-row>
                    </div>

                    <div class="category">
                        <h4 class="tit-common clr-blue">Danh mục</h4>
                        <b-row>
                            <b-col cols="4"><a class="d-block mb-4 bg-blue" href="#">Phụng vụ</a></b-col>
                            <b-col cols="4"><a class="d-block mb-4 bg-red" href="#">Giáo luật</a></b-col>
                            <b-col cols="4"><a class="d-block mb-4 bg-orange" href="#">Kinh thánh</a></b-col>
                            <b-col cols="4"><a class="d-block mb-4 bg-green" href="#">Tài liệu</a></b-col>
                            <b-col cols="4"><a class="d-block mb-4 bg-pink" href="#">Dòng tu</a></b-col>
                            <b-col cols="4"><a class="d-block mb-4 bg-grow" href="#">Giáo lý</a></b-col>
                        </b-row>
                    </div>

                    <div class="info mt-3">
                        <h4 class="tit-common clr-orange"><img src="../assets/img/icon-book.png" alt=""> Thông báo</h4>
                        <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 3" :key="index">
                            <span>
                                <i class="status bg-green">Live</i>
                            </span>
                            <span>50 năm thành lập giáo phận Phú Cường</span>
                            <span>Thanh Thúy</span>
                        </a>
                    </div>

                    <div class="calendar mt-4">
                        <h4 class="title"><span>Lịch</span></h4>
                        <b-calendar class="w-100" locale="en-US"></b-calendar>
                    </div>

                    <div class="fanpage mt-4">
                        <h4 class="tit-common clr-orange">fanpage</h4>
                        <div class="fb-page fb_iframe_widget" data-href="https://www.facebook.com/truyenthongphucuong/" data-tabs="timeline, messages" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" fb-xfbml-state="rendered" fb-iframe-plugin-query="adapt_container_width=true&amp;app_id=210446675691863&amp;container_width=350&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Ftruyenthongphucuong%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=true&amp;tabs=timeline%2C%20messages&amp;width="><span style="vertical-align: bottom; width: 350px; height: 500px;">
                            <iframe name="f34b797b58338a" width="1000px" height="1000px" data-testid="fb:page Facebook Social Plugin" title="fb:page Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" src="https://www.facebook.com/v5.0/plugins/page.php?adapt_container_width=true&amp;app_id=210446675691863&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df2eb147e0af6c64%26domain%3Dgiaophanphucuong.org%26origin%3Dhttps%253A%252F%252Fgiaophanphucuong.org%252Ff46cb85af4ed18%26relation%3Dparent.parent&amp;container_width=350&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Ftruyenthongphucuong%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=true&amp;tabs=timeline%2C%20messages&amp;width=350" style="border: none; visibility: visible; width: 350px; height: 500px;"></iframe></span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="tit-common clr-orange">Hạnh các thánh</h4>
                        <div id="Hanhcacthanh-PlaylistYoutube" class="embed-responsive embed-responsive-4by3">
                            <iframe allowfullscreen="" class="embed-responsive-item" frameborder="0" height="360" src="https://www.youtube-nocookie.com/embed/videoseries?list=PL-uyh2tqni7nLxdHqWjTbLyIoJEriY7lM" width="640"></iframe>
                        </div>
                    </div>
                </b-col>
            </b-row>
        </div>
  </main>
</template>

<script>
	import{
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


    export default {
        name: 'NewsDetailPage',
        components: {
            MainMenu,
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters(MODULE_INFO_DETAIL, [
                'pageLists'
            ]),
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
    @import './new-detail-styles.scss'
</style>