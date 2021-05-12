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
                        <b-carousel-slide
                            img-src="https://giaophanphucuong.org/Image/Picture/Images/CacGiaoXu/HatPhuCuong/NhaThoChanhToa-Thuml.jpg"
                            v-for="(link, index) in 3" :key="index">
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
                                    <b-carousel-slide
                                        img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                    <b-carousel-slide
                                        img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>
                                </b-carousel>
                            </b-col>
                        </b-row>
                    </div>
                </b-col>
            </b-row>

            <content-bottom v-if="isContentBottom"></content-bottom>
        </div>
    </main>
</template>

<script>
    import MainMenu from 'com@front/Common/MainMenu';
    import TabInfoViewedAndPopular from 'com@front/Common/TabInfoViewedAndPopular';
    import ContentBottom from 'com@front/Common/ContentBottom';

    export default {
        name: 'InfoPage',
        components: {
            MainMenu,
            TabInfoViewedAndPopular,
            ContentBottom,
        },
        data() {
            return {
                isContentBottom: true
            }
        },
    }
</script>

<style lang="scss">
    @import './news-styles.scss';
</style>
