<template>
    <div id="footer">
        <div class="top-footer py-4">
            <div class="container">
                <div class="row">
                    <div class="col-3 text-center col-info">
                        <p class="mb-4"><img src="../../../views/front/assets/img/logo.png" alt="Logo Phú Cường"></p>
                        <h4 class="title mb-3">Giáo Phận Phú Cường</h4>
                        <p class="mb-0">Ban Truyền Thông Giáo Phận</p>
                        <p>104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương</p>
                        <p class="mb-0">+84 274 730 7788</p>
                        <p class="mb-0">giaophanphucuong@gmail.com</p>
                    </div>
                    <div class="col-5">
                        <h4 class="tit-ft mb-3">Ứng dụng</h4>
                        <div class="row mb-3 pb-3 row-item-app" v-for="item in 3" :key="item">
                            <div class="col-4 col-img pl-0">
                                <img class="img" src="../../../views/front/assets/img/image_footer.jpg" alt="Hình ảnh Phú Cường">
                            </div>
                            <div class="col-8 col-detail pl-0">
                                <h4 class="tit-app-ft mt-2">App sách nói công giáo</h4>
                                <a class="link-app d-block mb-2" href="#">- Download từ Apple Store</a>
                                <a class="link-app d-block" href="#">- Download từ CH Play</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <h4 class="tit-ft mb-3">Quan tâm</h4>
                        <p class="font-weight-bold">Đăng ký để nhận tin mỗi ngày</p>
                        <div class="form">
                            <input class="d-block mb-3" type="email" name="email" id="email" placeholder="Enter your e-mail address">
                            <input class="btn" type="button" value="Subscribe">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <div class="container">
                <p>Copyright 2021 By Giáo Phận Phú Cường, All rights reserved. Powered by Catholic.App.Team</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Footer',
        components: {}
    };
</script>

<style lang="scss" scoped>
    #footer {
        color: #fff;
        .top-footer {
            background-color: #4D4D4D;
            word-break: break-word;
            .row {
                margin-right: 0;
                margin-left: 0;
                .col-info {
                    .title {
                        text-transform: uppercase;
                        font-size: 15px;
                    }
                    img {
                        width: 25%;
                    }
                    p {
                        font-size: 13px;
                    }
                }
                .tit-ft {
                    color: #FFFF00;
                    font-size: 16px;
                    text-transform: uppercase;
                    border-bottom: 1px solid #B3B3B3;
                    padding-bottom: 10px;
                }
                .col-img {
                    height: 80px;
                }
                .col-detail {
                    .tit-app-ft {
                        font-size: 16px;
                        text-transform: uppercase;
                    }
                    .link-app {
                        color: #8CC63F;
                        text-decoration: none;
                        &:hover {
                            font-weight: bold;
                        }
                    }
                }
                .row-item-app {
                    border-bottom: 1px dotted #B3B3B3;
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
                        &:hover {
                            opacity: .7;
                        }
                    }
                }
            }
        }
        .bottom-footer {
            background-color: #1A1A1A;
            text-align: center;
            padding: 10px;
            p {
                font-size: 13px;
                margin-bottom: 0;
            }
        }
    }

    @media screen and (max-width: 767px) {
        #footer {
            .top-footer {
                padding: 15px 0 !important;
                font-size: 13px;

                .row {
                    .col-3,
                    .col-4,
                    .col-5 {
                        max-width: 100%;
                        flex: unset;
                        display: block;
                        padding:  0;
                    }
                    
                    .col-info {
                        margin-bottom: 20px;

                        .title {
                            font-size: 12px;
                        }

                        img {
                            width: 25%;
                        }
                        
                        p {
                            font-size: 12px;
                        }
                    }

                    .tit-ft {
                        font-size: 12px;
                        padding-bottom: 5px;
                    }

                    .col-img {
                        height: 100%;
                        padding-right: 0;
                    }

                    .col-detail {
                        .tit-app-ft {
                            font-size: 12px;
                        }
                    }

                    .form {
                        margin-top: 20px;

                        #email {
                            padding: 4px;
                        }

                        .btn {
                            padding: 4px 12px;
                            font-size: 13px;
                        }
                    }
                }
            }

            .bottom-footer {
                padding: 10px 0;
                p {
                    font-size: 12px;
                }
            }
        }
    }
</style>