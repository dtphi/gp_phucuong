<template>
    <div id="footer">
        <div class="container">
            <div class="gr-footer">
                <div class="col col-info">
                    <p class="img"><img src="../../../views/front/assets/img/logo.png" alt=""></p>
                    <h4>GIÁO PHẬN PHÚ CƯỜNG</h4>
                    <p>Ban Truyền Thông Giáo Phận</p>
                    <p>104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương</p>
                    <p>+84 274 730 7788</p>
                    <p><a href="mailto:giaophanphucuong@gmail.com">giaophanphucuong@gmail.com</a></p>
                </div>
                <div class="col col-news">
                    <div class="AsideTitle">
                        <span class="name">Bài mới</span>
                    </div>
                    <a class="col-image-news" href="#">
                        <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                        <span>05h00 | Thánh Lễ Trực Tuyến | Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B | Ngày 24.02.2021.</span>
                    </a>
                    <a class="col-image-news" href="#">
                        <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                        <span>Suy Niệm Lời Chúa: Thứ Tư Sau Chúa Nhật I Mùa Chay Năm B, 24/02/2021</span>
                    </a>
                    <a class="col-image-news" href="#">
                        <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                        <span>Suy Niệm Lời Chúa: Thứ Ba Sau Chúa Nhật I Mùa Chay Năm B, 23/02/2021</span>
                    </a>
                    <a class="col-image-news" href="#">
                        <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                        <span>ĐTC Phanxicô gửi sứ điệp video đến Đại hội Giáo dục tôn giáo tại Los Angeles</span>
                    </a>
                    <a class="col-image-news" href="#">
                        <span><img src="https://img.youtube.com/vi/imaXNBZejB8/0.jpg" alt=""></span>
                        <span>ĐTC chấp nhận đơn từ nhiệm của ĐHY Robert Sarah</span>
                    </a>
                </div>
                <div class="col col-category">
                    <div class="AsideTitle">
                        <span class="name">Danh mục</span>
                    </div>
                    <div class="col-sroll">
                        <a href="#">video</a>
                        <a href="#">audio</a>
                        <a href="#">Cơ Sở Vật Chất</a>
                        <a href="#">Nhà Thờ Chánh Tòa</a>
                        <a href="#">Năm Thánh</a>
                        <a href="#">Giám Mục</a>
                        <a href="#">Tin Giáo Phận</a>
                        <a href="#">Tin Giáo Hội Việt Nam</a>
                        <a href="#">video</a>
                        <a href="#">video</a>
                        <a href="#">video</a>
                        <a href="#">video</a>
                        <a href="#">video</a>
                        <a href="#">video</a>
                        <a href="#">video</a>
                        <a href="#">video</a>
                    </div>
                </div>
                <div class="col col-connect">
                    <div class="AsideTitle">
                        <span class="name">Liên kết Website</span>
                    </div>
                    <div class="col-sroll">
                        <a href="#">Vatican</a>
                        <a href="#">Liên HĐGM Á châu</a>
                        <a href="#">Hội Đồng Giám Mục Việt Nam</a>
                        <a href="#">Giáo phận Bà Rịa</a>
                        <a href="#">Giáo phận Bắc Ninh</a>
                        <a href="#">Giáo phận Bùi Chu</a>
                        <a href="#">Giáo phận Cần Thơ</a>
                        <a href="#">Giáo Phận Đà Lạt</a>
                        <a href="#">Giáo Phận Đà Lạt</a>
                        <a href="#">Giáo Phận Đà Lạt</a>
                        <a href="#">Giáo Phận Đà Lạt</a>
                        <a href="#">Giáo Phận Đà Lạt</a>
                        <a href="#">Giáo Phận Đà Lạt</a>
                    </div>
                </div>
                <p class="copy-right">Copyright 2016 By Giáo Phận Phú Cường, All rights reserved. Powered by Catholic.App.Team</p>
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
        background-color: #252525;
        color: #fff;
        .gr-footer {
            font-size: 0;
            padding: 20px 0;
            .col {
                width: 25%;
                display: inline-block;
                font-size: 13px;
                padding: 0 15px;
                vertical-align: top;
                &.col-info {
                    .img {
                        img {
                            width: 40%;
                            margin-left: 40px;
                        }
                    }
                    h4 {
                        font-size: 16px;
                    }
                    a {
                        color: #fff;
                    }
                }
                .AsideTitle {
                    .name {
                        &::before {
                            background-color: #252525;
                        }
                    }
                }
                .col-sroll {
                    max-height: 330px;
                    overflow-y: scroll;
                    a {
                        border-bottom: 1px solid rgba(255, 255, 255, 0.4);
                        color: #eee;
                        display: block;
                        padding: 10px 15px 10px 0;
                        text-transform: uppercase;
                    }
                    &::--webkit-scrollbar-track {
                        background-color: #252525;
                    }
                    &::-webkit-scrollbar {
                        width: 5px;
                    }
                    &::-webkit-scrollbar-thumb {
                        background-color: #eee;
                        border-radius: 10px;
                    }
                }
                .col-image-news {
                    color: #fff;
                }
            }
            .copy-right {
                font-size: 13px;
                text-align: center;
            }
        }
    }
</style>