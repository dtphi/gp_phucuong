<template>
    <div class="aside">

        <!-- Col notification -->
        <div class="col col-noti">
            <div class="AsideTitle">
                <span class="name">Thông báo</span>
            </div>
            <a class="big-noti" href="#">
                <img src="https://giaophanphucuong.org//Image/_thumbs/Picture/Images/giam-muc-chinh-toa-giuse-nguyen-tan-tuoc.jpg" alt="">
                <div class="description">
                    <span class="info">
                        <i class="box">Tiêu điểm</i>
                        <i>Thông tin giáo phận</i>
                    </span>
                    <span class="tit">THÔNG BÁO: Về Phòng Tránh Dịch Covid-19 Trong Tình Hình Mới</span>
                    <span>
                        <em class="icon-small icon-clock icon-white">26/02/2021</em>
                        <em class="icon-small icon-eyes icon-white">30</em>
                    </span>
                </div>
            </a>
            <a class="col-image-news col-l" href="#" v-for="item in 4" :key="item">
                <span><img src="https://giaophanphucuong.org//Image/_thumbs/Picture/TinTuc/TinGiaoPhan/Album/PHONG%20CHUC/Linh-Muc-k15/Thanh-Le-Truyen-Chuc-Linh-Muc-2021-17.jpg" alt=""></span>
                <span>
                    Giáo Phận Phú Cường – Thánh Lễ Truyền Chức Linh Mục
                    <em class="icon-small icon-clock">26/02/2021</em>
                    <em class="icon-small icon-eyes">38</em>
                </span>
            </a>
        </div>

        <!-- Col audio -->
        <div class="col col-audio">
            <h4 class="title-bg">
                <span>Audio</span>
            </h4>
            <iframe height="430" scrolling="no" src="https://www.podbean.com/media/player/multi?playlist=http%3A%2F%2Fplaylist.podbean.com%2F10852551%2Fplaylist_multi.xml&amp;vjs=1&amp;size=430&amp;skin=1&amp;episode_list_bg=%23ffffff&amp;bg_left=%23000000&amp;bg_mid=%230c5056&amp;bg_right=%232a1844&amp;podcast_title_color=%23c4c4c4&amp;episode_title_color=%23ffffff&amp;auto=0&amp;share=1&amp;fonts=Helvetica&amp;download=1&amp;rtl=0&amp;show_playlist_recent_number=10" style="border: none;" title="Sách nói công giáo" width="100%"></iframe>
        </div>

        <!-- Col calendar -->
        <div class="col col-calendar">
            <h4 class="title-bg">
                <span>Lịch</span>
            </h4>
            <div>
                <b-calendar v-model="value" :date-disabled-fn="dateDisabled" locale="en"></b-calendar>
            </div>
        </div>

        <!-- Col social -->
        <div class="col col-social">
            <div class="AsideTitle">
                <span class="name">Social</span>
            </div>
            <div class="fb-page fb_iframe_widget" data-href="https://www.facebook.com/truyenthongphucuong/" data-tabs="timeline, messages" data-width="" data-height="" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" fb-xfbml-state="rendered" fb-iframe-plugin-query="adapt_container_width=true&amp;app_id=210446675691863&amp;container_width=290&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Ftruyenthongphucuong%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=true&amp;tabs=timeline%2C%20messages&amp;width=">
                <span style="vertical-align: bottom; width: 290px; height: 500px;">
                    <iframe name="f19746773c336fc" width="1000px" height="1000px" data-testid="fb:page Facebook Social Plugin" title="fb:page Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" src="https://www.facebook.com/v5.0/plugins/page.php?adapt_container_width=true&amp;app_id=210446675691863&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df27e80ed1b7f23c%26domain%3Dgiaophanphucuong.org%26origin%3Dhttps%253A%252F%252Fgiaophanphucuong.org%252Ff1ea38e4f6a036c%26relation%3Dparent.parent&amp;container_width=290&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2Ftruyenthongphucuong%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=true&amp;tabs=timeline%2C%20messages&amp;width=" style="border: none; visibility: visible; width: 290px; height: 500px;" class=""></iframe>
                </span>
            </div>
        </div>

        <!-- Col most visited -->
        <div class="col col-noti">
            <div class="AsideTitle">
                <span class="name">Bài xem nhiều </span>
            </div>
            <a class="big-noti mt-20" href="#">
                <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/Document/New-Images/2017-03/tin-mung-mt-5-20-26.jpg" alt="">
                <div class="description">
                    <span class="info">
                        <i>Suy Niệm Hằng Ngày</i>
                    </span>
                    <span class="tit">Suy Niệm Thứ Sáu Tuần I Mùa Chay B - GKGĐ Giáo Phận Phú Cường</span>
                    <span>
                        <em class="icon-small icon-clock icon-white">26/02/2021</em>
                        <em class="icon-small icon-eyes icon-white">30</em>
                    </span>
                </div>
            </a>
            <a class="col-image-news col-l" href="#" v-for="item in 4" :key="item">
                <span><img src="https://giaophanphucuong.org//Image/_thumbs/Picture/TinTuc/TinGiaoPhan/Album/PHONG%20CHUC/Linh-Muc-k15/Thanh-Le-Truyen-Chuc-Linh-Muc-2021-17.jpg" alt=""></span>
                <span>
                    Giáo Phận Phú Cường – Thánh Lễ Truyền Chức Linh Mục
                    <em class="icon-small icon-clock">26/02/2021</em>
                    <em class="icon-small icon-eyes">38</em>
                </span>
            </a>
        </div>

        <!-- Col salt for life -->
        <div class="col col-salt-for-life">
            <div class="AsideTitle">
                <span class="name">Muối men cho đời</span>
            </div>
            <a class="col-image-news col-l" :class="[item == 1 ? 'mt-20' : '']" href="#" v-for="item in 5" :key="item">
                <span><img src="https://giaophanphucuong.org//Image/_thumbs/Picture/TinTuc/TinGiaoPhan/Album/PHONG%20CHUC/Linh-Muc-k15/Thanh-Le-Truyen-Chuc-Linh-Muc-2021-17.jpg" alt=""></span>
                <span>
                    Giáo Phận Phú Cường – Thánh Lễ Truyền Chức Linh Mục
                    <em class="ad-red">Admin-</em>
                    <em class="icon-small icon-clock">26/02/2021</em>
                </span>
            </a>
        </div>

        <!-- Col video -->
        <div class="col col-video">
            <div class="AsideTitle">
                <span class="name">Hạnh Các Thánh</span>
            </div>
            <iframe allowfullscreen="" class="embed-responsive-item mt-20" frameborder="0" height="220px" src="https://www.youtube-nocookie.com/embed/videoseries?list=PL-uyh2tqni7nLxdHqWjTbLyIoJEriY7lM"></iframe>
        </div>

        <!-- Col story -->
        <div class="col col-story">
            <div class="AsideTitle">
                <span class="name">Truyện suy tư</span>
            </div>
            <a class="img mt-20" href="#">
                <img src="https://giaophanphucuong.org/Image/_thumbs/Picture/Images/hay-den-cung-thanh-giuse.jpg" alt="">
            </a>
            <div class="description">
                <h4>Hãy đến cùng Thánh Giuse</h4>
                <div>
                    <span class="icon-small icon-clock">26/02/2021</span>
                    <span class="icon-small icon-eyes">38</span>
                </div>
            </div>
            <p class="txt">
                Một người nổi bật trong cuộc đời Chúa Giêsu là thánh Giuse, người cha nuôi, 
                nhưng là một người lặng thầm ít được kể đến trong Thánh Kinh, cũng như trong Thánh Gia...
            </p>
        </div>

        <!-- Col music -->
        <div class="col col-music">
            <div class="AsideTitle">
                <span class="name">Nhạc Beat</span>
            </div>
            <div class="list-music">
                <figure>
                    <audio
                        controls
                        src="">
                            Your browser does not support the
                            <code>audio</code> element.
                    </audio>
                    <figcaption>Beat - Đêm Noel</figcaption>
                </figure>
            </div>
        </div>

        <!-- Col tag -->
        <div class="col col-tag">
            <div class="AsideTitle">
                <span class="name">Tags</span>
            </div>
        </div>

        <!-- Col register -->
        <div class="col col-register">
            <div class="AsideTitle">
                <span class="name">Đăng ký nhận tin</span>
            </div>
            <div class="form">
                <input class="input" type="email" name="" id="" placeholder="Email của bạn">
                <button class="btn-submit" type="submit">Subscribe</button>
            </div>
        </div>

        <!-- Col connect -->
        <div class="col col-connect">
            <h4 class="tit">Nối kết</h4>
            <div class="link-connect">
                <a href="#"><img src="https://giaophanphucuong.org/Image/Picture/Banner/VATICAN.jpg" alt=""></a>
                <a href="#"><img src="https://giaophanphucuong.org/Image/Picture/Banner/hdgmvn.jpg" alt=""></a>
                <a href="#"><img src="https://giaophanphucuong.org/Image/Picture/Banner/DCVXUANLOC.jpg" alt=""></a>
                <a href="#"><img src="https://giaophanphucuong.org/Image/Picture/Banner/CHANLYACHAU.jpg" alt=""></a>
                <a href="#"><img src="https://giaophanphucuong.org/Image/Picture/lINK/Asset%204.png" alt=""></a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AsideNews'
}
</script>

<style lang="scss" scoped>
    .aside {
        .mt-20 {
            margin-top: -20px;
        }
        .col-l {
            .icon-small {
                display: inline-block;
                font-style: normal;
                margin-top: 4px;
                font-size: 12px;
            }
        }
        .col {
            padding: 0;
            .AsideTitle {
                border-top: 3px solid #000;
                .name {
                    background: #000;
                    color: #fff;
                    font-size: 12px;
                    font-weight: 700;
                    padding: 4px 8px;
                    &::before {
                        background-color: #000;
                        width: 0;
                    }
                }
            }
            &.col-noti {
                .big-noti {
                    position: relative;
                    display: block;
                    height: 200px;
                    margin-bottom: 20px;
                    img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                    .description {
                        background-color: rgba(0, 0, 0, 0.5);
                        color: #fff;
                        position: absolute;
                        bottom: 0;
                        padding: 10px 14px;
                        span {
                            display: block;
                            &.info {
                                i {
                                    display: inline-block;
                                    font-style: normal;
                                }
                                .box {
                                    background-color: #ff224d;
                                    color: #fff;
                                    margin-right: 10px;
                                    padding: 0px 4px;
                                }
                            }
                            &.tit {
                                font-size: 14px;
                                font-weight: 700;
                                text-transform: uppercase;
                                margin: 4px 0;
                            }
                            em {
                                display: inline-block;
                                font-style: normal;
                            }
                        }
                    }
                }
            }
            &.col-audio {
                margin: 20px 0;
                .title-bg {
                    background-color: #000;
                    color: #fff;
                    text-transform: uppercase;
                    margin: 0;
                    padding: 8px 14px;
                    font-size: 13px;
                }
            }
            &.col-calendar {
                .title-bg {
                    background-color: #000;
                    color: #fff;
                    text-transform: uppercase;
                    margin: 0;
                    padding: 8px 14px;
                    font-size: 13px;
                }
            }
            &.col-social {
                .fb-page {
                    margin-top: -20px;
                }
            }
            &.col-salt-for-life {
                .col-image-news {
                    span {
                        .ad-red {
                            color: #DF2124;
                            font-weight: 700;
                            font-style: normal;
                            margin-right: 10px;
                        }
                    }
                }
            }
            &.col-story {
                .img {
                    display: block;
                    height: 220px;
                    img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover
                    }
                }
                .description {
                    h4 {
                        font-size: 13px;
                        font-weight: 700;
                        margin: 10px 0;
                        text-transform: uppercase;
                    }
                }
            }
            &.col-music {
                .list-music {
                    .ui360 {
                        min-height: 50px;
                        margin-bottom: 10px;
                        padding-bottom: 10px;
                        border-bottom: 1px solid #ddd;
                        width: 100%;
                        display: table;
                    }
                }
            }
            &.col-register {
                .form {
                    .input {
                        width: 100%;
                        border: 1px solid rgba(0,0,0,.15);
                        border-radius: 5px;
                        padding: 8px 10px;
                    }
                    .btn-submit {
                        background-color: #000;
                        border: 2px solid #000;
                        color: #fff;
                        width: 100%;
                        text-transform: uppercase;
                        margin-top: 12px;
                        padding: 12px;
                        border-radius: 5px;
                        cursor: pointer;
                        &:hover {
                            background-color: #fff;
                            color: #000;
                        }
                    }
                }
            }
            &.col-connect {
                background-color: #F5F4EF;
                border: 1px solid rgba(0,0,0,.125);
                margin-top: 30px;
                .tit {
                    font-size: 16px;
                    font-weight: 700;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
                    margin: 0;
                    padding: 8px;
                    text-align: center;
                    text-transform: uppercase;
                }
                .link-connect {
                    padding: 15px;
                    a {
                        display: block;
                        font-size: 0;
                        margin-bottom: 10px;
                        &:last-child {
                            margin-bottom: 0;
                        }
                        &:hover {
                            opacity: .7;
                        }
                        img {
                            width: 100%;
                        }
                    }
                }
            }
        }
    }
</style>