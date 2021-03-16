<template>
    <div class="content">

        <!-- Col say god -->
        <div class="col col-say-god">
            <div class="AsideTitle">
                <span class="name">Lời chúa</span>
            </div>
            <b-tabs class="menu-tabs" content-class="mt-3">
                <b-tab :title="tab" :active="false" v-for="tab in tabsSayGold" :key="tab">
                    <div class="box">
                        <div class="col-box col-50">
                            <a class="img" href="#">
                                <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/Images/Screen%20Shot%202021-02-23%20at%2010_00_10.png" alt="">
                                <div class="description">
                                    <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                                    <div>
                                        <span class="icon-small icon-clock">26/02/2021</span>
                                        <span class="icon-small icon-eyes">38</span>
                                    </div>
                                </div>
                            </a>
                            <a class="img" href="#">
                                <div class="description">
                                    <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                                    <div>
                                        <span class="icon-small icon-clock">26/02/2021</span>
                                        <span class="icon-small icon-eyes">38</span>
                                    </div>
                                </div>
                            </a>
                            <a class="img" href="#">
                                <div class="description">
                                    <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                                    <div>
                                        <span class="icon-small icon-clock">26/02/2021</span>
                                        <span class="icon-small icon-eyes">38</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-box col-50 col-l">
                            <a class="col-image-news" href="#" v-for="item in 5" :key="item">
                                <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                                <span>
                                    05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.
                                    <em class="icon-small icon-clock">26/02/2021</em>
                                </span>
                            </a>
                        </div>
                    </div>
                </b-tab>
            </b-tabs>
            <div class="dropdown">
                <b-dropdown text="Xem thêm">
                    <b-dropdown-item-button class="text-dropdown">Chú giải kinh thánh</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Mỗi ngày một câu chuyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Phút cầu nguyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Lectio Divina</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Suy Niệm Với Đức Thánh Cha</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Muối Men Cho Đời</b-dropdown-item-button>
                </b-dropdown>
            </div>
        </div>

        <!-- Col salt for life -->
        <div class="col col-salt-for-life">
            <div class="AsideTitle">
                <span class="name">Muối Men Cho Đời</span>
            </div>
            <b-tabs class="menu-tabs" content-class="mt-3">
                <b-tab :title="tab" :active="false" v-for="tab in tabsSaltForLife" :key="tab">
                    <div class="box">
                        <div class="col-box">
                            <h4 class="tit-box mt-2"><a href="#">Muối Men Cho Đời 194: Bài Giảng Chúa Nhật II Mùa Chay Năm B - Lm. Giuse Nguyễn Tường Vĩnh Lộc</a></h4>
                            <div>
                                <span class="icon-small icon-clock">26/02/2021</span>
                                <span class="icon-small icon-eyes">38</span>
                            </div>
                            <div class="col-image">
                                <a class="img-life col-box col-50" href="#">
                                    <img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt="">
                                </a>
                                <p class="txt col-box col-50">Muối Men Cho Đời 194: Bài Giảng Chúa Nhật II Mùa Chay Năm B. Mc 9: 2 - 10. Lm. Giuse Nguyễn Tường Vĩnh Lộc...</p>
                            </div>
                            <div class="col-box col-50 col-l">
                                <a class="col-image-news" href="#" v-for="item in 2" :key="item">
                                    <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                                    <span>
                                        05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.
                                        <em class="icon-small icon-clock">26/02/2021</em>
                                    </span>
                                </a>
                            </div>
                            <div class="col-box col-50 col-l">
                                <a class="col-image-news" href="#" v-for="item in 2" :key="item">
                                    <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                                    <span>
                                        05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.
                                        <em class="icon-small icon-clock">26/02/2021</em>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </b-tab>
            </b-tabs>
            <div class="dropdown">
                <b-dropdown text="Xem thêm">
                    <b-dropdown-item-button class="text-dropdown">Chú giải kinh thánh</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Mỗi ngày một câu chuyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Phút cầu nguyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Lectio Divina</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Suy Niệm Với Đức Thánh Cha</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Muối Men Cho Đời</b-dropdown-item-button>
                </b-dropdown>
            </div>
        </div>

        <!-- Col diocese -->
        <div class="col col-diocese">
            <div class="AsideTitle">
                <span class="name">Tin Giáo Phận</span>
                <ul class="menu-aside">
                    <li class="active"><a href="#">Tất cả</a></li>
                </ul>
            </div>
            <div class="slide-image">
                <VueSlickCarousel :arrows="true">
                    <a class="col-slide" href="#" v-for="item in 4" :key="item">
                        <figure class="box-image">
                            <img src="https://giaophanphucuong.org/Image/Picture/TinTuc/TinGiaoPhan/Album/GxBung/Tet-2021/GXBung-tet-2021-8.jpg" alt="">
                            <figcaption class="description">
                                <h4 class="title">Giáo Xứ Búng Mừng Xuân Mới 2021</h4>
                                <p class="txt">Sáng Mùng Một tết Nguyên đán (ngày 12-02-2021), lúc 6g00, tiếng chuông hồi hai vang lên đón bình minh ngày đầu năm mới, 
                                    thánh lễ do cha sở Simon Nguyễn Văn Thu, cha Giuse Nguyễn Anh Hùng cùng đồng tế; cùng nam nữ Tu sĩ, 
                                    bà con giáo dân Búng hiệp nguyện dâng lên Thiên Chúa một năm mới an bình, thánh đức.</p>
                                <div class="icon-fix">
                                    <span class="icon-small icon-clock icon-white">26/02/2021</span>
                                    <span class="icon-small icon-eyes icon-white">30</span>
                                </div>
                            </figcaption>
                        </figure>
                    </a>
                    <template #prevArrow>
                        <div class="prevArrow">Prev</div>
                    </template>
                    <template #nextArrow>
                        <div class="nextArrow">Next</div>
                    </template>
                </VueSlickCarousel>
            </div>
            <div class="box">
                <div class="col-box col-new-3" v-for="item in 3" :key="item">
                    <a class="img" href="#">
                        <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/Images/Screen%20Shot%202021-02-23%20at%2010_00_10.png" alt="">
                        <span class="cat-name">Tin Giáo Phận</span>
                        <div class="description">
                            <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                            <div>
                                <span class="icon-small icon-clock">26/02/2021</span>
                                <span class="icon-small icon-eyes">38</span>
                            </div>
                        </div>
                    </a>
                    <a class="img" href="#" v-for="item in 2" :key="item">
                        <div class="description">
                            <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                            <div>
                                <span class="icon-small icon-clock">26/02/2021</span>
                                <span class="icon-small icon-eyes">38</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Col news -->
        <div class="col col-news">
            <div class="box">
                <div class="col-box col-50">
                    <div class="AsideTitle">
                        <span class="name">Tin Giáo Hội Hoàn Vũ</span>
                        <ul class="menu-aside">
                            <li class="active"><a href="#">Xem thêm</a></li>
                        </ul>
                    </div>
                    <a class="img" href="#">
                        <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/Images/Screen%20Shot%202021-02-23%20at%2010_00_10.png" alt="">
                        <span class="cat-name">Tin Giáo Hội Hoàn Vũ</span>
                        <div class="description">
                            <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                            <div>
                                <span class="icon-small icon-clock">26/02/2021</span>
                                <span class="icon-small icon-eyes">38</span>
                            </div>
                        </div>
                    </a>
                    <p class="txt ellipsis-three-lines">Sáng thứ Sáu 26/02/2021, tại Đại thính đường Phaolô VI, 
                        Đức Hồng y Raniero Cantalamessa đã có bài giảng Mùa Chay đầu tiên. 
                        “Thời kỳ đã mãn, và Triều Đại Thiên Chúa đã đến gần. 
                        Anh em hãy sám hối và tin vào Tin Mừng” (Mc 1,15), là đoạn Kinh Thánh được Đức Hồng y diễn giải trong bài giảng...</p>
                    
                    <a class="col-image-news" href="#" v-for="item in 3" :key="item">
                        <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                        <span>
                            05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.
                            <em class="icon-small icon-clock">26/02/2021</em>
                        </span>
                    </a>
                </div>
                <div class="col-box col-50">
                    <div class="AsideTitle">
                        <span class="name">Tin Giáo Hội Việt Nam</span>
                        <ul class="menu-aside">
                            <li class="active"><a href="#">Xem thêm</a></li>
                        </ul>
                    </div>
                    <a class="img" href="#">
                        <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/Images/Screen%20Shot%202021-02-23%20at%2010_00_10.png" alt="">
                        <span class="cat-name">Tin Giáo Hội Việt Nam</span>
                        <div class="description">
                            <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                            <div>
                                <span class="icon-small icon-clock">26/02/2021</span>
                                <span class="icon-small icon-eyes">38</span>
                            </div>
                        </div>
                    </a>
                    <p class="txt ellipsis-three-lines">
                        Thời gian qua, dịch cúm Covid-19 bùng phát trở lại trong cộng đồng với biến chủng mới nguy hiểm hơn, và vào ngay dịp chúng ta đón mừng Tết Tân Sửu, 
                        dịp con cháu đi làm, đi học từ các nơi trở về gia đình, về quê; dịp họ hàng, thân hữu họp mặt, gặp gỡ nhau, khiến nguy cơ lây nhiễm cộng đồng hiện nay đang rất cao. 
                        Trong tình hình này, lãnh ý Quý Đức Cha, Văn phòng Toà Giám mục xin thông báo:
                    </p>

                    <a class="col-image-news" href="#" v-for="item in 3" :key="item">
                        <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                        <span>
                            05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.
                            <em class="icon-small icon-clock">26/02/2021</em>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Col service -->
        <div class="col col-service">
            <div class="AsideTitle">
                <span class="name">Phụng Vụ</span>
            </div>
            <b-tabs class="menu-tabs" content-class="mt-3">
                <b-tab :title="tab" :active="false" v-for="tab in tabsSaltForLife" :key="tab">
                    <div class="box">
                        <div class="col-box col-new-3 col-l" v-for="item in 6" :key="item">
                            <a class="col-image-news" href="#">
                                <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                                <span>
                                    <i class="ellipsis-two-lines">05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.</i>
                                    <em class="icon-small icon-clock">26/02/2021</em>
                                </span>
                            </a>
                        </div>
                    </div>
                </b-tab>
            </b-tabs>
            <div class="dropdown">
                <b-dropdown text="Xem thêm">
                    <b-dropdown-item-button class="text-dropdown">Chú giải kinh thánh</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Mỗi ngày một câu chuyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Phút cầu nguyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Lectio Divina</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Suy Niệm Với Đức Thánh Cha</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Muối Men Cho Đời</b-dropdown-item-button>
                </b-dropdown>
            </div>
        </div>

        <!-- Col ebook -->
        <div class="col col-ebook">
            <a href="#">
                <img src="https://giaophanphucuong.org/Image/Picture/Images/LichCongGiao2021.png" alt="">
                <div class="description">
                    <h4 class="tit">EBOOK LỊCH CÔNG GIÁO 2020-2021</h4>
                    <p class="txt">EBOOK LỊCH CÔNG GIÁO 2020-2021: Đây là Ebook lịch công giáo, có thể sử dụng trên nền tảng IOS hay Android. 
                        Đối với Iphone và Ipad: sử dụng ứng dụng iBook để đọc; Đối với các loại SmartPhone sử dụng hệ điều hành Android, 
                        cần phải cài ứng dụng đọc PDF để đọc.</p>
                    <div>
                        <span class="icon-small icon-clock">26/02/2021</span>
                        <span class="icon-small icon-eyes">38</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Col document -->
        <div class="col col-document">
            <div class="AsideTitle">
                <span class="name">Tài Liệu</span>
            </div>
            <b-tabs class="menu-tabs" content-class="mt-3">
                <b-tab :title="tab" :active="false" v-for="tab in tabsSaltForLife" :key="tab">
                    <div class="box">
                        <div class="col-box col-50">
                            <a class="img" href="#">
                                <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/Images/Screen%20Shot%202021-02-23%20at%2010_00_10.png" alt="">
                                <div class="description">
                                    <h4>Suy Niệm Lời Chúa: Chúa Nhật II Mùa Chay Năm B, 28/02/2021</h4>
                                    <div>
                                        <span class="icon-small icon-clock">26/02/2021</span>
                                        <span class="icon-small icon-eyes">38</span>
                                    </div>
                                </div>
                            </a>
                            <p class="txt">Sáng thứ Sáu 26/02/2021, tại Đại thính đường Phaolô VI, 
                                Đức Hồng y Raniero Cantalamessa đã có bài giảng Mùa Chay đầu tiên. 
                                “Thời kỳ đã mãn, và Triều Đại Thiên Chúa đã đến gần. 
                                Anh em hãy sám hối và tin vào Tin Mừng” (Mc 1,15), là đoạn Kinh Thánh được Đức Hồng y diễn giải trong bài giảng...</p>
                        </div>
                        <div class="col-box col-50 col-l">
                            <a class="col-image-news" href="#" v-for="item in 5" :key="item">
                                <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                                <span>
                                    05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.
                                    <em class="icon-small icon-clock">26/02/2021</em>
                                    <em class="icon-small icon-eyes">38</em>
                                </span>
                            </a>
                        </div>
                    </div>
                </b-tab>
            </b-tabs>
            <div class="dropdown">
                <b-dropdown text="Xem thêm">
                    <b-dropdown-item-button class="text-dropdown">Chú giải kinh thánh</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Mỗi ngày một câu chuyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Phút cầu nguyện</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Lectio Divina</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Suy Niệm Với Đức Thánh Cha</b-dropdown-item-button>
                    <b-dropdown-item-button class="text-dropdown">Muối Men Cho Đời</b-dropdown-item-button>
                </b-dropdown>
            </div>
        </div>

        <!-- Col document -->
        <div class="col col-album-news">
            <div class="title-album">
                <h4><a href="#">News Album</a></h4>
            </div>
            <div class="list-album">
                <div class="col-album-2">
                    <a class="big" href="#"><img src="https://giaophanphucuong.org/Image/_thumbs/Picture/TinTuc/TinGiaoPhan/Album/GxBung/Tet-2021/GXBung-tet-2021-1.jpg" alt=""></a>
                </div>
                <div class="col-album-2">
                    <a class="col-album-3" href="#" v-for="item in 9" :key="item">
                        <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/TinTuc/TinGiaoPhan/Album/GxBung/Tet-2021/GXBung-tet-2021-1.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>

        <!-- Col video -->
        <div class="col col-list-video">
            <h4 class="title"><a href="#">Video</a></h4>
            <div class="slide-video">
                <VueSlickCarousel
                    class="slide-1"
                    ref="c1"
                    :asNavFor="$refs.c2"
                    :arrows="false"
                    @beforeChange="syncSliders"
                    :focusOnSelect="true">
                    <div v-for="index in 6" :key="index">
                        <div class="video-fr">
                            <iframe src="https://www.youtube.com/embed/hk1XfMf2j-I?rel=1&amp;autoplay=1&amp;showinfo=0" frameborder="no" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </VueSlickCarousel>
                <VueSlickCarousel
                    class="slide-2"
                    ref="c2"
                    :asNavFor="$refs.c1"
                    v-bind="settings"
                    @beforeChange="syncSliders"
                    :slidesToShow="4"
                    :focusOnSelect="true">
                    <div v-for="index in 6" :key="index">
                        <div class="col-image-news">
                            <span><img src="https://img.youtube.com/vi/Oo7nAWHE-pY/0.jpg" alt=""></span>
                            <span>
                                <em class="tit">Muối Men Thời Sự</em>
                                <em class="txt">ĐIỂM TIN GIÁO HỘI HOÀN VŨ 02.03.2021</em>
                                <em class="icon-small icon-eyes">20</em>
                            </span>
                        </div>
                    </div>
                    <template #prevArrow>
                        <div class="prevArrow">Prev</div>
                    </template>
                    <template #nextArrow>
                        <div class="nextArrow">Next</div>
                    </template>
                </VueSlickCarousel>
            </div>
        </div>
    </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
// optional style for arrows & dots
// import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    name: 'ContentNews',
    components: { VueSlickCarousel },
    data() {
        return {
            isShowDropdown: false,
            settings: {
                "infinite": true,
                "slidesToShow": 3,
                "slidesToScroll": 1,
                "vertical": true,
                "verticalSwiping": true
            },
            tabsSayGold: [
                'Tất cả',
                'Suy niệm hàng ngày',
                'Suy niệm chúa nhật'
            ],
            tabsSaltForLife: [
                'Tất cả',
                'Muối Men Lời Chúa',
                'Thánh Ca'
            ]
        }
    },
    methods: {
        say: function() {
            this.isShowDropdown = !this.isShowDropdown;
        },
        syncSliders(currentPosition, nextPosition) {
            this.$refs.c1.next()
            this.$refs.c2.prev()
        },
    }
}
</script>

<style lang="scss">
    .content {
        .AsideTitle {
            .menu-aside {
                background: #fff;
                position: absolute;
                right: 0;
                top: -16px;
                list-style-type: none;
                margin: 0;
                padding: 0;
                li {
                    display: inline-block;
                    margin-left: 20px;
                    color: #333;
                    &.active, &:hover {
                        color: #FFA204;
                    }
                }
                a {
                    color: #000;
                }
                .more {
                    border: 1px solid #adadad;
                    background-color: #fff;
                    border-radius: 4px;
                    color: #333;
                    padding: 6px 16px;
                    cursor: pointer;
                    outline: 0;
                }
                .dropdown {
                    position: relative;
                    .list-more {
                        background-color: #fff;
                        border: 1px solid rgba(0,0,0,.15);
                        border-radius: .25rem;
                        position: absolute;
                        right: 0;
                        margin-top: 2px;
                        padding: 6px 12px;
                        width: 160px;
                        z-index: 10;
                        li {
                            display: block;
                            margin: 0 0 6px 0;
                            &:last-child {
                                margin: 0;
                            }
                        }
                    }
                }
            }
        }
        .box {
            font-size: 0;
            .col-box {
                display: inline-block;
                font-size: 14px;
                vertical-align: top;
                &:first-child {
                    margin-right: 20px;
                }
                &.col-50 {
                    width: calc(( 100% - 20px ) / 2);
                }
                &.col-new-3 {
                    width: calc(( 100% - 40px ) / 3);
                    &:nth-child(2) {
                        margin-right: 20px;
                    }
                }
                .img {
                    display: block;
                    border-bottom: 1px solid #ddd;
                    padding: 10px 0;
                    &:first-child {
                        padding-top: 0;
                    }
                    &:last-child {
                        border-bottom: none;
                    }
                    &:hover {
                        h4 {
                            color: #FFA204;
                        }
                    }
                    img {
                        width: 100%;
                        margin-bottom: 20px;
                    }
                    .description {
                        font-size: 12px;
                        color: #000;
                        h4 {
                            margin: 0 0 10px;
                            font-size: 14px;
                        }
                    }
                }
                &.col-l {
                    .icon-small {
                        display: block;
                        font-style: normal;
                        margin-top: 10px;
                        font-size: 12px;
                    }
                }
            }
        }
        .col {
            padding: 0;
            &.col-salt-for-life {
                .box {
                    .col-box {
                        .tit-box {
                            font-size: 16px;
                            margin: -10px 0 5px;
                            &:hover {
                                color: #FFA204;
                            }
                            a {
                                color: #000;
                            }
                        }
                    }
                    .col-image {
                        font-size: 0;
                        margin: 15px 0 20px;
                        .img-life {
                            margin-right: 0;
                            padding-right: 14px;
                            height: 200px;
                            img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                            }
                        }
                        .txt {
                            margin: 0;
                        }
                    }
                }
            }
            &.col-diocese {
                .slide-image {
                    .col-slide {
                        display: block;
                        .box-image {
                            position: relative;
                            margin: 0;
                            height: 350px;
                            &::before {
                                background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.7) 100%);
                                bottom: 0;
                                content: "";
                                display: block;
                                height: 80%;
                                width: 100%;
                                position: absolute;
                            }
                            .description {
                                color: #fff;
                                position: absolute;
                                bottom: 0;
                                padding: 25px 50px;
                                .title {
                                    margin: 0;
                                    font-size: 18px;
                                }
                            }
                            img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                            }
                        }
                    }
                }
                .box {
                    .col-box {
                        .img {
                            padding: 15px 0;
                            img {
                                margin-bottom: 2px;
                            }
                        }
                        .cat-name {
                            background-color: #ff224d;
                            display: inline-block;
                            color: #fff;
                            font-size: 12px;
                            margin-bottom: 14px;
                            padding: 2px 10px;
                            text-transform: uppercase;
                        }
                    }
                }
            }
            &.col-news {
                .box {
                    .col-box {
                        .img {
                            margin-bottom: 10px;
                            padding: 15px 0;
                            img {
                                margin-bottom: 2px;
                            }
                        }
                        .cat-name {
                            background-color: rgba(0,0,0,0.5);
                            display: inline-block;
                            color: #fff;
                            margin-bottom: 14px;
                            padding: 2px 10px;
                        }
                        .col-image-news {
                            .icon-small {
                                display: block;
                                font-style: normal;
                                margin-top: 4px;
                                font-size: 12px;
                            }
                        }
                    }
                }
            }
            &.col-service {
                .box {
                    .col-box {
                        &.col-new-3 {
                            margin-right: 20px;
                            &:nth-child(3n) {
                                margin-right: 0;
                            }
                        }
                        i {
                            font-style: normal;
                        }
                        .icon-small {
                            margin-top: 2px;
                        }
                    }
                }
            }
            &.col-ebook {
                position: relative;
                margin: 30px 0;
                a {
                    display: block;
                    height: 250px;
                    img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                    &:hover {
                        opacity: .7;
                    }
                }
                .description {
                    background-color: rgba(0,0,0,0.5);
                    color: #fff;
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 60%;
                    height: 100%;
                    padding: 20px;
                    .tit {
                        margin: 0 0 10px;
                        font-size: 16px;
                    }
                    .txt {
                        margin: 0 0 10px;
                        font-weight: 600;
                        line-height: 24px;
                    }
                }
            }
            &.col-album-news {
                .title-album {
                    padding: 10px 0;
                    background-color: #F8F8F6;
                    border: 1px solid #ddd;
                    margin-bottom: 15px;
                    h4 {
                        display: inline-block;
                        text-transform: uppercase;
                        font-weight: 700;
                        padding-left: 20px;
                        padding-right: 20px;
                        position: relative;
                        margin: 0;
                        font-size: 16px;
                        &::before {
                            content: "";
                            position: absolute;
                            top: -12px;
                            left: 0;
                            width: 100%;
                            height: 2px;
                            background-color: #FFA204;
                        }
                        a {
                            color: #000;
                        }
                    }
                }
                .list-album {
                    font-size: 0;
                    .col-album-2 {
                        display: inline-block;
                        font-size: 14px;
                        width: calc(( 100% - 8px ) / 2);
                        vertical-align: top;
                        &:first-child {
                            margin-right: 8px;
                        }
                        .big {
                            display: block;
                            height: 238px;
                        }
                    }
                    .col-album-3 {
                        display: inline-block;
                        font-size: 14px;
                        width: calc(( 100% - 16px ) / 3);
                        height: 74px;
                        margin: 0 8px 8px 0;
                        &:nth-child(3n) {
                            margin-right: 0;
                        }
                    }
                    a {
                        &:hover {
                            opacity: .7;
                        }
                    }
                    img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                }
            }
            &.col-list-video {
                margin: 20px 0 30px;
                .title {
                    background-color: #000;
                    margin: 0;
                    line-height: 0;
                    a {
                        background-color: #fc2f00;
                        color: #fff;
                        display: inline-block;
                        font-size: 12px;
                        margin: 0;
                        padding: 0 16px;
                        text-transform: uppercase;
                        height: 30px;
                        line-height: 30px;
                    }
                }
                .slide-video {
                    margin-top: 20px;
                    font-size: 0;
                    .slick-slider {
                        display: inline-block;
                        font-size: 14px;
                        vertical-align: top;
                        &.slide-1 {
                            width: 60%;
                            margin-right: 2%;
                        }
                        &.slide-2 {
                            width: 38%;
                            .col-image-news {
                                margin: 4px 0;
                                span {
                                    em {
                                        display: block;
                                        font-style: normal;
                                        &.tit {
                                            color: #fc2f00;
                                            font-weight: 600;
                                        }
                                        &.txt {
                                            white-space: nowrap;
                                            text-overflow: ellipsis;
                                            overflow: hidden;
                                        }
                                    }
                                }
                            }
                        }
                        .video-fr {
                            iframe {
                                width: 100%;
                                height: 350px;
                            }
                        }
                        .slick-arrow {
                            width: 100%;
                            height: 22px;
                            border-radius: 0;
                            &::before {
                                content: '';
                                display: inline-block;
                                width: 20px;
                                height: 20px;
                                margin-top: 8px;
                            }
                            &.slick-prev {
                                left: 0;
                                top: 0;
                                &::before {
                                    background: url('../../assets/img/icon_arrow_left.png') no-repeat;
                                    background-size: 100%;
                                }
                            }
                            &.slick-next {
                                right: 0;
                                top: 100%;
                                &::before {
                                    background: url('../../assets/img/icon_arrow_right.png') no-repeat;
                                    background-size: 100%;
                                }
                            }
                        }
                    }
                }
            }
        }
        .slick-slider {
            .slick-arrow {
                background-color: #000;
                width: 36px;
                height: 36px;
                border-radius: 4px;
                text-align: center;
                z-index: 1;
                &::before {
                    content: '';
                    display: inline-block;
                    width: 20px;
                    height: 20px;
                    margin-top: 8px;
                }
                &.slick-prev {
                    left: 0;
                    &::before {
                        background: url('../../assets/img/icon_arrow_left.png') no-repeat;
                        background-size: 100%;
                    }
                }
                &.slick-next {
                    right: 0;
                    &::before {
                        background: url('../../assets/img/icon_arrow_right.png') no-repeat;
                        background-size: 100%;
                    }
                }
            }
        }

        .menu-tabs {
            .nav-tabs {
                border-bottom: 3px solid #ffa204;
                li {
                    a {
                        color: #000;
                        border: 0;
                        &.active {
                            background-color: #ffa204;
                            font-weight: 500;
                        }
                    }
                }
            }
        }

        .dropdown {
            position: absolute;
            top: 24px;
            right: 0;
            .dropdown-toggle {
                background-color: #fff;
                color: #000;
                font-size: 13px;
                padding: 4px 8px;
            }
            .text-dropdown {
                font-size: 14px;
            }
        }
    }
</style>