<template>
    <div class="fz-0">
        <nav id="nav">
            <ul class="nav-menu">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Tin Giáo Phận</a></li>
                <li><a href="#">Tin Giáo Hội Hoàn Vũ</a></li>
                <li><a href="#">Tin Giáo Hội Việt Nam</a></li>
                <li><a href="#">Lời Chúa</a></li>
                <li><a href="#">Tài Liệu</a></li>
                <li><a href="#">Hôn Nhân - Gia Đình</a></li>
                <li><a href="#">Tiếng Việt Online</a></li>
                <li><a href="#">Văn Kiện</a></li>
            </ul>
        </nav>
        <div class="icon-nav">
            <p><b-icon class="person" icon="person-fill"></b-icon></p>
            <p><b-icon class="search" icon="search"></b-icon></p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Navigation'
    }
</script>

<style lang="scss" scoped>
    .fz-0 {
      font-size: 0;
    }

    #nav {
        border: 1px solid #ED1C24;
        background-color: #ffffff;
        width: 93%;
        display: inline-block;
        .nav-menu {
            margin-bottom: 0;
            padding-left: 0;
            list-style-type: none;
            font-size: 0;
            li {
                display: inline-block;
                &.active > a {
                    background-color: #ED1C24;
                    color: #ffffff;
                }
                a {
                    color: #000;
                    display: block;
                    font-size: 11px;
                    font-weight: 700;
                    padding: 10px 8px;
                    text-transform: uppercase;
                    text-decoration: none;
                    i {
                        font-size: 14px;
                    }
                }
            }
        }
        .nav-menu > li {
            ul {
                background-color: #fff;
                display: none;
                position: absolute;
                padding-left: 0;
                box-shadow: 0px 2px 6px -2px;
                z-index: 10;
                li {
                    display: block;
                    position: relative;
                    a {
                        font-size: 12px;
                        padding: 8px;
                        text-transform: none;
                    }
                    &:hover > a {
                        background-color: #ED1C24;
                        color: #ffffff;
                    }
                    &:hover {
                        ul {
                        display: block;
                        width: 100%;
                        top: 0;
                        left: 100%;
                        }
                    }
                }
            }
            &:hover > ul {
                display: block;
            }
            &:hover > a {
                background-color: #ED1C24;
                color: #fff;
                transition: none;
            }
        }
    }
    
    .icon-nav {
        background-color: #ffffff;
        border: 1px solid #ED1C24;
        width: 7%;
        display: inline-block;
        height: 38px;
        border-left: 0;
        vertical-align: top;
        p {
            font-size: 16px;
            width: 50%;
            margin-bottom: 0;
            display: inline-block;
            height: 38px;
            text-align: center;
            padding-top: 6px;
            cursor: pointer;
            &:last-child {
                background-color: #ED1C24;
                color: #ffffff;
            }
        }
    }

    @media screen and (max-width: 767px) {
        #nav {
            width: 75%;

            .nav-menu {
                li {
                    a {
                        font-size: 10px;
                        padding: 6px 6px;

                        i {
                            font-size: 14px;
                        }
                    }
                }
            }

            .nav-menu > li {
                ul {
                    box-shadow: 0px 2px 6px -2px;
                    li {
                        a {
                            font-size: 12px;
                            padding: 8px;
                        }
                    }
                }
            }
        }
        
        .icon-nav {
            width: 25%;
            height: 38px;
            p {
                font-size: 14px;
                width: 50%;
                height: 38px;
                padding-top: 6px;
            }
        }
    }
</style>