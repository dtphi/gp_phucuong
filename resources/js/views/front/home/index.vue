<template>
    <main id="homepage">
        <div class="container">
            <div class="">
                <div class="title-breaking-news">
                    <span class="tit">Bài mới</span>
                    <span class="arrow"></span>
                </div>
                <div class="content-breaking-news">
                </div>
                <!-- <b-carousel
                    id="carousel-1"
                    v-model="slide"
                    :interval="4000"
                    controls
                    indicators
                    background="#ababab"
                    img-width="1024"
                    img-height="480"
                    style="text-shadow: 1px 1px 2px #333;color: red; font-size: 20xp;"
                >
                    <b-carousel-slide v-for="index in 4" :key="index">
                        <h1>Hello world! {{ index }}</h1>
                    </b-carousel-slide>
                </b-carousel> -->
            </div>
            <div class="view-video">
                <div class="embed-video">
                    <iframe id="iframe-video" class="iframe-video" src="https://www.youtube.com/embed/say3Q95fjVs?feature=oembed&amp;modestbranding=1&amp;showinfo=0&amp;rel=0" allowfullscreen=""></iframe>
                </div>
                <div class="caption">
                    <h3 class="title">
                        <a href="#" title="05h00 | thanh le truc tuyen | thu bay sau thu tu le tro | ngay 20.02.2021.">05h00 | Thánh Lễ Trực Tuyến | Thứ Bảy Sau Thứ Tư Lễ Tro | Ngày 20.02.2021.</a>
                    </h3>
                    <div class="entry-meta">
                        <span class="CreateDate">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> 19/02/2021
                        </span>
                        <span class="Visited">
                            <i class="fa fa-eye" aria-hidden="true"></i> 78
                        </span>
                    </div>
                </div>
            </div>
            <div class="featured-posts">
                <a href="#" v-for="item in 5" :key="item">
                    <img src="https://giaophanphucuong.org/Image/Picture/Images/Phai-doan-toa-thanh-chuan-bi-cho-chuyen-vieng-tham-iraq.jpeg" alt="">
                    <div class="caption">
                        <div class="entry-meta">
                            <!-- <span class="CreateDate">
                                <i class="fa fa-clock-o" aria-hidden="true"></i> 19/02/2021
                            </span>
                            <span class="Visited">
                                <i class="fa fa-eye" aria-hidden="true"></i> 78
                            </span> -->
                            <span class="icon-small icon-clock icon-white">26/02/2021</span>
                            <span class="icon-small icon-eyes icon-white">38</span>
                        </div>
                        <h3 class="title">Thánh Giuse người cha âm thầm nhưng cao cả</h3>
                    </div>
                </a>
            </div>
            <tab-home />
            <main id="main">
                <div class="main-news">
                    <ContentNews />
                </div>
                <aside class="aside-news">
                    <AsideNews />
                </aside>
            </main>
        </div>
    </main>
</template>

<script>
    import VueSlickCarousel from 'vue-slick-carousel'
    // optional style for arrows & dots
    import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
    import TabHome from '../Tab/index'
    import ContentNews from '../home/child/content'
    import AsideNews from '../home/child/aside'

    export default {
        name: 'Home',
        components: {
            TabHome,
            ContentNews,
            AsideNews,
            VueSlickCarousel
        },
        data() {
            return {
                settings: {
                    arrows: true,
                    dots: true,
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    vertical: true,
                },
                slide: 0,
                sliding: null
            }
        },
    }
</script>

<style lang="scss" scoped>
    #homepage {
        margin-top: 10px;
        .entry-meta {
            span {
                color: #818a91;
                &.Visited {
                    margin-left: 10px;
                }
            }
        }
        .breaking-news {
            position: relative;
            .title-breaking-news {
                display: inline-block;
                font-size: 0;
                position: relative;
                span {
                    display: inline-block;
                    &.tit {
                        background-color: #fa3c2c;
                        color: #fff;
                        font-size: 16px;
                        padding: 4px 12px;
                    }
                    &.arrow {
                        width: 0;
                        height: 0;
                        border-style: solid;
                        border-width: 10px 0 10px 10px;
                        border-color: transparent transparent transparent #fa3c2c;
                        position: absolute;
                        top: 50%;
                        transform: translateY(-50%);
                    }
                }
            }
            .content-breaking-news {
                // display: inline-block;
                // margin-left: 30px;
                // position: absolute;
                // top: 50%;
                // transform: translateY(-50%);
                .slick-slider {
                    button {
                        background-color: red !important;
                    }
                }
                .slick-prev {
                    background-color: red  !important;
                }
                .news-slider {
                    a {
                        color: #000;
                        text-decoration: none;
                    }
                    .slick-list {
                        width: 90%;
                    }
                    .slick-arrow {
                        z-index: 10;
                        &::before {
                            background-size: 100%;
                            background-repeat: no-repeat;
                            content: '';
                            display: inline-block;
                            width: 20px;
                            height: 20px;
                        }
                        &.slick-prev {
                            left: auto;
                            right: 15px;
                            &::before {
                                // background-image: url('../img/arrow_prev.png');
                                content: '<'
                            }
                        }
                        &.slick-next {
                            right: 0;
                            &::before {
                                // background-image: url('../img/arrow_next.png');
                                content: '>'
                            }
                        }
                    }
                }
                // ul {
                //     list-style-type: none;
                //     margin: 0;
                //     padding: 0;
                //     li {
                //         a {
                //             color: #000;
                //             text-decoration: none;
                //         }
                //     }
                //     .slick-list {
                //     width: 90%;
                //     }
                //     .slick-arrow {
                //     z-index: 10;
                //     &::before {
                //         background-size: 100%;
                //         background-repeat: no-repeat;
                //         content: '';
                //         display: inline-block;
                //         width: 20px;
                //         height: 20px;
                //     }
                //     &.slick-prev {
                //         left: auto;
                //         right: 15px;
                //         &::before {
                //         background-image: url('../img/arrow_prev.png');
                //         }
                //     }
                //     &.slick-next {
                //         right: 0;
                //         &::before {
                //         background-image: url('../img/arrow_next.png');
                //         }
                //     }
                //     }
                // }
            }
        }
        .view-video {
            background-color: #000;
            .embed-video {
                margin-top: 10px;
                height: 420px;
                .iframe-video {
                    width: 100%;
                    height: 100%;
                    padding: 0 210px;
                }
            }
            .caption {
                padding: 0 30px 20px;
                .title {
                    a {
                        color: #fff;
                        font-size: 18px;
                        text-decoration: none;
                    }
                }
            }
        }
        .featured-posts {
            font-size: 0;
            margin-top: 3px;
            a {
                font-size: 13px;
                height: 220px;
                display: inline-block;
                position: relative;
                margin-bottom: 3px;
                &:first-child, &:nth-child(2) {
                    width: calc(( 100% - 3px) / 2);
                }
                &:first-child, &:nth-child(3), &:nth-child(4) {
                    margin-right: 3px;
                }
                &:nth-child(3), &:nth-child(4), &:nth-child(5) {
                    width: calc(( 100% - 6px) / 3 );
                }
                img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .caption {
                    position: absolute;
                    bottom: 0;
                    color: #fff;
                    padding: 15px;
                    .entry-meta {
                        span {
                            color: #fff;
                        }
                    }
                    .title {
                        margin: 2px 0 0;
                        font-size: 16px;
                        line-height: 16px;
                    }
                }
                &:hover {
                    opacity: .7;
                }
            }
        }
        #main {
            font-size: 0;
            .main-news, .aside-news {
                font-size: 14px;
                display: inline-block;
                vertical-align: top;
            }
            .main-news {
                width: 70%;
                padding-right: 15px;
            }
            .aside-news {
                width: 30%;
                padding-left: 15px;
            }
        }
    }
</style>