<template>
    <div>
        <nav class="navbar navbar-light sticky-top bg-white flex-md-nowrap border-bottom p-0">
            <b-link :to="{ name: 'admin.menu.main.menu' }" class="navbar-brand col-6 mr-0 px-3 d-block d-md-none">
                <b-img src="/img/logo.png" height="45"></b-img>
            </b-link>

            <b-button type="button"
                      class="navbar-toggler position-absolute d-md-none collapsed"
                      data-toggle="collapse"
                      data-target="#sidebar-menu"
                      aria-controls="sidebar-menu"
                      aria-expanded="false"
                      aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </b-button>
        </nav>

        <div class="bg-divpage"></div>

        <TheSidebar></TheSidebar>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-0 custom-main">
            <TheHeader></TheHeader>
            <slot></slot>
        </main>

        <TheFooter></TheFooter>
    </div>
</template>

<script>
    import TheHeader from '../_partials/TheHeader';
    import TheSidebar from '../_partials/TheSidebar';
    import TheFooter from '../_partials/TheFooter';

    export default {
        name: 'AdminLayout',
        components: {
            TheHeader,
            TheSidebar,
            TheFooter
        }
    };
</script>

<style lang="scss">
    html, body, #app {
        font-family: Verdana, "ヒラギノ角ゴ ProN W3", "ヒラギノ角ゴ ProN W6", "Hiragino Kaku Gothic ProN", "游ゴシック", YuGothic, "メイリオ", Meiryo, sans-serif;
        height: 100%;
    }

    body {
        background: #f4f4f5;
    }

    .navbar {
        .navbar-brand {
            font-size: 1rem;
            padding-bottom: .75rem;
            padding-top: .75rem;
        }

        .navbar-toggler {
            right: 1rem;
            top: 1rem;
        }
    }

    .bg-divpage {
        background: rgb(210, 235, 246);
        background: linear-gradient(120deg, #00d3e8 0%, #008ccf 60%, #0089cf 100%);
        height: 300px;
        left: 0;
        position: absolute;
        top: 0;
        width: 100%;
    }
</style>