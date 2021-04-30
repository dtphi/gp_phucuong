<template>
  <main id="news" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <b-row class="mt-3 notication">
                <b-col cols="8" class="col-mobile">
                    <b-carousel
                        id="carousel-1"
                        :interval="4000"
                        controls
                        indicators
                        >
                        <b-carousel-slide img-src="https://giaophanphucuong.org/Image/Picture/Images/CacGiaoXu/HatPhuCuong/NhaThoChanhToa-Thuml.jpg"  v-for="(link, index) in 3" :key="index">
                            <div class="description text-left">
                                <h4>Thông báo:</h4>
                                <p class="mb-2">
                                    Ban Truyền Thông Giáo Phận 104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương...
                                    <a href="#" class="ml-2"><b>Xem thêm</b></a>
                                </p>
                                <p class="text-right mb-0">25/12/2021 Thanh Thúy</p>
                            </div>
                        </b-carousel-slide>
                    </b-carousel>
                </b-col>
                <b-col cols="4" class="col-mobile">
                    <div class="box-social">
                        <h4 class="tit-common clr-blue">Mạng xã hội</h4>
                        <div class="list-icon">
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                            <a href="#"><img src="../assets/img/icon-book.png" alt=""></a>
                        </div>

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
                                    <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                    <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                </b-carousel>
                            </b-col>
                        </b-row>
                    </div>
                </b-col>
            </b-row>

            <div class="highlights mt-3">
                <h4 class="tit-highlights"><span>Nổi bật</span></h4>

                <b-row>
                    <b-col cols="4" class="mb-3 col-mobile">
                        <h4 class="tit-common">Sách nói</h4>
                        <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                            <span>Chí khí - đường hi vọng</span>
                            <span>
                                <img src="../assets/img/icon-book.png" alt="">
                                <i>Thanh Thúy</i>
                            </span>
                        </a>
                    </b-col>
                    <b-col cols="4" class="mb-3 col-mobile">
                        <h4 class="tit-common">Youtube</h4>
                        <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                            <span>Chí khí - đường hi vọng</span>
                            <span>
                                <img src="../assets/img/icon-book.png" alt="">
                                <i>Thanh Thúy</i>
                            </span>
                        </a>
                    </b-col>
                    <b-col cols="4" class="mb-3 col-mobile">
                        <h4 class="tit-common">Hát thanh vịnh</h4>
                        <a href="#" class="row-item-2" v-for="(item, index) in 4" :key="index">
                            <span>Chí khí - đường hi vọng</span>
                            <span>
                                <img src="../assets/img/icon-book.png" alt="">
                                <i>Thanh Thúy</i>
                            </span>
                        </a>
                    </b-col>
                </b-row>

                <b-row class="mt-2">
                    <b-col cols="8" class="col-mobile">
                        <div class="say-gods">
                            <h4 class="tit-common mb-3"><img src="../assets/img/icon-book.png" alt=""> Lời chúa</h4>
                            <b-row>
                                <b-col cols="5" class="col-mobile">
                                    <a class="d-block" href="#"><img class="img" src="../assets/img/image_footer.jpg" alt=""></a>
                                    <h4 class="tit-bg-common mt-2">
                                        <span><i class="bg-red">Nổi bật</i></span>
                                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                                    </h4>
                                    <p><em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa</em></p>
                                    <p class="info-post text-right">
                                        <img src="../assets/img/icon-book.png" alt="">
                                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>
                                </b-col>
                                <b-col cols="7" class="col-mobile">
                                    <p class="info-post">
                                        <span>13/2/2019</span>
                                        <span class="name font-weight-bold ml-1">Giuse Quỳnh</span>
                                    </p>
                                    <h4 class="tit-bg-common">
                                        <span><i class="bg-green">Mới</i></span>
                                        <a href="#">Suy niệm chúa Nhật IV mùa chay B</a>
                                    </h4>
                                    <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                                    <p class="mb-2"><em>Thưa quý chúng sinh, quý tu sĩ, cùng toàn thể giáo dân giáo phận Phú Cường, trong tâm tình tạ ơn thiên chúa...</em></p>
                                    <a class="font-weight-bold" href="#">Xem thêm</a>
                                    <hr>
                                    <a href="#" class="row-item-3 d-block mb-2 pb-2" v-for="(item, index) in 5" :key="index">
                                        <span>
                                            <i class="status bg-orange">Nổi bật</i>
                                        </span>
                                        <span>
                                            Suy niệm chúa Nhật IV mùa chay B
                                        </span>
                                        <span class="text-right">
                                            20/2/2021
                                        </span>
                                    </a>
                                </b-col>
                            </b-row>
                        </div>

                        <b-row class="mt-4">
                            <b-col cols="6" class="col-mobile">
                                <div class="new mt-3">
                                    <h4 class="tit-common mb-3"><img src="../assets/img/icon-book.png" alt=""> Tin giáo hội</h4>
                                    <p class="info-post mb-2">
                                        <img src="../assets/img/icon-book.png" alt="">
                                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>
                                    <h4 class="tit-bg-common">
                                        <span><i class="bg-orange">hot</i></span>
                                        <a href="#">Chúc mừng Đức Tổng Giám Mục Leopoldo Girelli</a>
                                    </h4>
                                    <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                                    <a class="d-block" href="#"><img class="img" src="../assets/img/image_footer.jpg" alt=""></a>
                                    
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
                                            <img src="../assets/img/icon-book.png" alt="">
                                            <i>Điểm tin giáo hội</i>
                                        </span>
                                        <span>
                                            <img src="../assets/img/icon-book.png" alt="">
                                            <i>Thanh Thúy</i>
                                        </span>
                                    </a>
                                </div>
                            </b-col>

                            <b-col cols="6" class="col-mobile">
                                <div class="new mt-3">
                                    <h4 class="tit-common mb-3"><img src="../assets/img/icon-book.png" alt=""> Tin giáo hội việt nam</h4>
                                    <p class="info-post mb-2">
                                        <img src="../assets/img/icon-book.png" alt="">
                                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>
                                    <h4 class="tit-bg-common">
                                        <span><i class="bg-green">live</i></span>
                                        <a href="#">Chúc mừng Đức Tổng Giám Mục Leopoldo Girelli</a>
                                    </h4>
                                    <p class="name-post font-weight-bold mb-2">Posted by THANH LONG</p>
                                    <a class="d-block" href="#"><img class="img" src="../assets/img/image_footer.jpg" alt=""></a>
                                    
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
                                            <img src="../assets/img/icon-book.png" alt="">
                                            <i>Điểm tin giáo hội</i>
                                        </span>
                                        <span>
                                            <img src="../assets/img/icon-book.png" alt="">
                                            <i>Thanh Thúy</i>
                                        </span>
                                    </a>
                                </div>
                            </b-col>
                        </b-row>

                        <div class="mt-4 new-diocese">
                            <h4 class="tit-common mb-3">
                                <img src="../assets/img/icon-book.png" alt=""> Tin giáo phận
                                <a href="#" class="view-all">View all</a>
                            </h4>
                            <b-row>
                                <b-col cols="7" class="col-mobile">
                                    <a class="d-block" href="#"><img class="img" src="../assets/img/image_footer.jpg" alt=""></a>
                                    <h4 class="tit-bg-common mt-2">
                                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                                    </h4>
                                    <p class="info-post">
                                        <img src="../assets/img/icon-book.png" alt="">
                                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>
                                </b-col>
                                <b-col cols="5" class="col-r col-mobile">
                                    <a class="d-block" href="#"><img class="img" src="../assets/img/image_footer.jpg" alt=""></a>
                                    <h4 class="tit-bg-common mt-2">
                                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                                    </h4>
                                    <p class="info-post">
                                        <img src="../assets/img/icon-book.png" alt="">
                                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>

                                    <hr class="my-2">

                                    <h4 class="tit-bg-common">
                                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                                    </h4>
                                    <p class="info-post">
                                        <img src="../assets/img/icon-book.png" alt="">
                                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>

                                    <hr class="my-2">

                                    <h4 class="tit-bg-common">
                                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                                    </h4>
                                    <p class="info-post">
                                        <img src="../assets/img/icon-book.png" alt="">
                                        <span class="name font-weight-bold mr-1">Giuse Quỳnh</span>
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>
                                </b-col>
                            </b-row>
                        </div>

                        <div class="mt-4 new-document">
                            <h4 class="tit-common mb-3">
                                <img src="../assets/img/icon-book.png" alt=""> Văn kiện
                                <a href="#" class="view-all">View all</a>
                            </h4>
                            <b-row>
                                <b-col cols="4" class="col-mobile" v-for="(item, index) in 3" :key="index">
                                    <a class="d-block" href="#"><img class="img" src="../assets/img/image_footer.jpg" alt=""></a>
                                    <h4 class="tit-bg-common mt-2">
                                        <a href="#">Thông báo: Bế mạc năm thánh mừng kính các thánh tử đạo Việt Nam</a>
                                    </h4>
                                    <p class="info-post">
                                        <b-icon class="alarm" icon="alarm"></b-icon>
                                        <span>12/03/2021</span>
                                    </p>
                                </b-col>
                            </b-row>
                        </div>
                    </b-col>

                    <b-col cols="4" class="col-mobile">
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

                        <div class="info">
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
                            <b-calendar class="w-100"  locale="en-US"></b-calendar>
                        </div>

                        <div class="fanpage mt-4">
                            <h4 class="tit-common clr-orange">fanpage</h4>
                            <div class="fb-page fb_iframe_widget" data-href="https://www.facebook.com/truyenthongphucuong/" data-tabs="timeline, messages" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" fb-xfbml-state="rendered">
                                <iframe width="350px" height="500px" data-testid="fb:page Facebook Social Plugin" title="fb:page Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" src="https://www.facebook.com/v5.0/plugins/page.php?adapt_container_width=true&amp;app_id=210446675691863&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df2eb147e0af6c64%26domain%3Dgiaophanphucuong.org%26origin%3Dhttps%253A%252F%252Fgiaophanphucuong.org%252Ff46cb85af4ed18%26relation%3Dparent.parent&amp;container_width=330&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Ftruyenthongphucuong%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=true&amp;tabs=timeline%2C%20messages&amp;width=330"></iframe>
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
        </div>
  </main>
</template>

<script>
	import{
      mapState,
      mapActions
  } from 'vuex';
  import MainMenu from 'com@front/Common/MainMenu';
  import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';

  import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_DETAIL,
        GET_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';


    export default {
        name: 'VideoPage',
        components: {
            MainMenu,
            TabInfoViewedAndPopular
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapState(MODULE_INFO,{
                infoList: state => state.pageLists
            }),
        },
        mounted() {
            this.[GET_INFORMATION_LIST_TO_CATEGORY](this.$route.params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_DETAIL,GET_INFORMATION_LIST_TO_CATEGORY
            ]),
        }
    }
</script>

<style lang="scss">
    @import './news-styles.scss'
</style>