<template>
    <main id="video" class="py-2">
        <div class="container">
            <Navigation />
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
    import Navigation from 'com@front/Navigation';

    export default {
        name: 'Video',
        components: {
            Navigation,
        },
        data() {
            return {

            }
        },
    }
</script>

<style lang="scss" scoped>
    #video {
        .aside {
            .menu {
                list-style-type: none;
                padding-left: 0;

                li {
                    margin-bottom: 8px;
                    cursor: pointer;

                    &:hover,
                    &.active {
                        background-color: #dee2e6;
                    }

                    img {
                        width: 8%;
                        margin-right: 10px;
                    }

                    a {
                        color: #000000;
                        text-decoration: none;
                        display: block;
                        padding: 5px;
                    }
                }
            }

            .form {
                #email {
                    background-color: #CCCCCC;
                    padding: 8px;
                    border-radius: 4px;
                    width: 100%;
                    outline: 0;
                }

                .btn {
                    background-color: #ED1C24;
                    color: #ffffff;
                    padding: 7px 20px;
                    font-weight: bold;
                }

                .txt {
                    color: #CCCCCC;
                }
            }

            .logo {
                font-size: 13px;
                text-align: center;

                img {
                    width: 30%;
                }

                .title {
                    text-transform: uppercase;
                    font-size: 15px;
                }
            }
        }

        .list-videos {
            background-color: #dee2e6;
            padding: 15px;

            .figure {
                width: calc((100% - 60px)/4);
                margin-right: 20px;
                margin-bottom: 20px;
                vertical-align: top;
                cursor: pointer;

                &:nth-child(4n) {
                    margin-right: 0;
                }
            }

            .figure-caption {
                color: #000000;

                .title {
                    font-size: 14px;

                    img {
                        width: 10%;
                    }
                }
            }
        }
    }

    @media screen and (max-width: 767px) {
        #video {
            .row {
                .col-3,
                .col-9 {
                    max-width: 100%;
                    flex: unset;
                }
            }

            .border {
                margin: 10px 0 !important;
            }

            .aside {
                .menu {
                    font-size: 12px;

                    li {
                        margin-bottom: 6px;

                        img {
                            width: 6%;
                            margin-right: 6px;
                        }

                        a {
                            display: block;
                            padding: 2px;
                        }
                    }
                }

                .form {
                    font-size: 12px;
                    
                    #email {
                        margin-bottom: 8px !important;
                        padding: 4px;
                    }

                    .btn {
                        padding: 4px 12px;
                        font-size: 12px;
                    }
                }

                .logo {
                    font-size: 12px;
                    img {
                        width: 25%;
                    }

                    .title {
                        font-size: 13px;
                    }
                }
            }

            .list-videos {
                margin-top: 20px;
                padding: 10px;
                font-size: 12px;

                .figure {
                    width: calc((100% - 10px)/2);
                    margin-right: 10px;
                    margin-bottom: 20px;

                    &:nth-child(2n),
                    &:nth-child(4n) {
                        margin-right: 0;
                    }
                }

                .figure-caption {
                    .title {
                        font-size: 13px;
                    }
                }
            }
        }
    }
</style>