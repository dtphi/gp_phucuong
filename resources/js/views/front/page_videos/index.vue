<template>
  <main id="video" class="py-2">
        <div class="container">
            <navigation-main :menu-items="navMainLists"></navigation-main>
            <b-row class="mt-3">
                <b-col cols="3">
                    <aside class="aside">
                        <ul class="menu">
                            <li class="active"><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Tất cả</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Xem nhiều</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Đã xem</a></li>
                            <hr class="border my-3">
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Thánh ca</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Lời chúa</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Kinh thánh</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Thời sự</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Tiếng việt</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Bé kể bé nghe</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Giáo lý</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Chuyên đề</a></li>
                            <li><a href="#"><img src="../../../views/front/assets/img/icon-book.png" alt="Icon">Karaoke</a></li>
                        </ul>

                        <hr class="border my-3">

                        <div class="form">
                            <p class="font-weight-bold txt">Đăng ký để nhận tin mỗi ngày</p>
                            <div class="input">
                                <input class="d-block mb-3" type="email" name="email" id="email" placeholder="Enter your e-mail address">
                                <input class="btn" type="button" value="Subscribe">
                            </div>
                        </div>

                        <hr class="border my-4">

                        <div class="logo">
                            <p class="mb-4"><img src="../../../views/front/assets/img/logo.png" alt="Logo Phú Cường"></p>
                            <h4 class="title mb-3">Giáo Phận Phú Cường</h4>
                            <p class="mb-0">Ban Truyền Thông Giáo Phận</p>
                            <p>104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương</p>
                            <p class="mb-0">+84 274 730 7788</p>
                            <p class="mb-0">giaophanphucuong@gmail.com</p>
                        </div>
                    </aside>
                </b-col>
                <b-col cols="9">
                    <div class="list-videos">
                        <figure class="figure" v-for="item in 20" :key="item">
                            <img src="../assets/img/banner_image.jpg" class="rounded img" alt="Giáo Phận Phú Cường">
                            <figcaption class="figure-caption">
                                <h4 class="title mt-2">
                                    <img src="../../../views/front/assets/img/icon-book.png" alt="Icon">
                                    Tình chúa thương con
                                </h4>
                                <span class="d-block mb-1">Bao la tình chúa thương con, mênh mông như biển thái bình</span>
                                <span class="d-block mb-1">Trình bày: Phi Nguyễn</span>
                                <span class="d-block">20N lượt xem | 3 tháng trước</span>
                            </figcaption>
                        </figure>
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
  import NavigationMain from 'com@front/Navigation/Main';

    export default {
        name: 'VideoPage',
        components: {
            NavigationMain,
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters(['navMainLists'])
        },
    }
</script>

<style lang="scss">
    @import './video-styles.scss'
</style>