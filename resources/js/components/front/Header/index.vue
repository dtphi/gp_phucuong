<template>
    <header id="header">
        <div class="container">
            <div class="header-top">
                <div class="header-time">
                    <i class="fa fa-calendar"></i> Thứ Năm, Ngày 18-2-2021
                    <i class="fa fa-clock-o"></i> 10:08:39
                </div>
                <div class="header-social">
                    <div class="icon-social">
                        <a href="#"><font-awesome-icon class="icon" :icon="{ prefix: 'fab', iconName: 'youtube' }"/></a>
                        <a href="#"><font-awesome-icon class="icon" :icon="{ prefix: 'fab', iconName: 'google' }"/></a>
                        <a href="#"><font-awesome-icon class="icon" :icon="{ prefix: 'fab', iconName: 'facebook' }"/></a>
                        <a href="#"><font-awesome-icon class="icon" :icon="{ prefix: 'fab', iconName: 'twitter' }"/></a>
                    </div>
                    <div class="search-header">
                        <input class="text-search" type="text" placeholder="Tìm kiếm.." name="search">
                        <button class="btn-search" type="submit"><font-awesome-icon icon="search" /></button>
                    </div>
                </div>
            </div>

            <!-- Banner header -->
            <div class="banner">
                <a href="#"><img class="w-100" alt="Giáo Phận Phú Cường" itemprop="logo" longdesc="Giáo Phận Phú Cường" src="https://giaophanphucuong.org/Image/Picture/Logo/logo-lg.jpg" title="Giáo Phận Phú Cường"></a>
            </div>

            <!-- Menu navigator -->
            <Navigation />
        </div>
    </header>
</template>

<script>
    import Navigation from 'com@front/Navigation';

    export default {
        name: 'Header',
        components: {
            Navigation
        }
    };
</script>

<style lang="scss" scoped>
    #header {
        .header-top {
            border-radius: 1px;
            border-top: 3px solid #034a2a;
            box-shadow: 0 3px 7px -3px;
            margin-bottom: 3px;
            margin-top: 2px;
            .header-time {
                color: #999;
                font-weight: 500;
                display: inline-block;
                border-right: 1px solid #999;
                padding: 0 10px;
                margin-bottom: 3px;
                font-size: 12px;
            }
            .header-social {
                float: right;
                .icon-social {
                    font-size: 0;
                    display: inline-block;
                    a {
                        font-size: 14px;
                        padding: 2px 4px;
                        .icon {
                            color: #888;
                        }
                        &:hover {
                            background-color: #888;
                            .icon {
                                color: #fff;
                            }
                        }
                    }
                }
                .search-header {
                    font-size: 0;
                    display: inline-block;
                    border-left: 1px solid #999;
                    .text-search {
                        padding: 1px 4px;
                        font-size: 12px;
                        border: none;
                        outline: none;
                    }
                    .btn-search {
                        padding: 3px 7px;
                        background: #034a2a;
                        color: #fff;
                        font-size: 14px;
                        border: none;
                        cursor: pointer;
                    }
                }
            }
        }
        .banner {
            a {
                display: block;
                font-size: 0;
                img {
                    width: 100%;
                }
            }
        }
    }
</style>