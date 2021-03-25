<template>
    <header id="header">
        <div class="header-news">
            <div class="container">
                <div class="breaking-news d-inline-block">
                    <h4 class="title-breaking-news d-inline-block">breaking news:</h4>
                    <p class="txt-breaking-news d-inline-block">Thứ 4 tuần V thường niên C - GKCĐ Giáo phận Phú Cường</p>
                </div>
                <div class="subscribe d-inline-block">
                    <button class="btn">subscribe</button>
                </div>
            </div>
        </div>
        <div class="header-image">
            <div class="container">
                <div class="logo d-inline-block">
                    <img src="../../../views/front/assets/img/logo.png" alt="Logo Phú Cường">
                </div>
                <div class="banner-image d-inline-block">
                    <img class="img" src="../../../views/front/assets/img/banner_image.jpg" alt="Hình ảnh Phú Cường">
                </div>
            </div>
            </div>
    </header>
</template>

<script>
    export default {
        name: 'Header'
    };
</script>

<style lang="scss" scoped>
    #header {
        background-color: #ED1C24;
        .header-news {
            background-color: #C1272D;
            color: #ffffff;
            font-size: 0;
            .breaking-news {
                width: 80%;
                font-size: 14px;
                .title-breaking-news {
                    font-size: 14px;
                    margin: 0 60px 0 0;
                    text-transform: uppercase;
                }
                .txt-breaking-news {
                    margin-bottom: 0;
                }
            }
            .subscribe {
                width: 20%;
                font-size: 14px;
                background-color: #ED1C24;
                text-align: center;
                .btn {
                    color: #ffffff;
                    text-transform: uppercase;
                    font-size: 14px;
                    width: 100%;
                }
            }
        }
        .header-image {
            font-size: 0;
            padding: 15px 0;
            .logo {
                width: 30%;
                img {
                    width: 20%;
                }
            }
            .banner-image {
                width: 70%;
                height: 100px;
            }
        }
    }
</style>