<template>
    <nav id="nav" class="mt-0">
        <b-nav>
            <b-nav-item class="active">Home</b-nav-item>
            <b-nav-item>Tin giáo phận</b-nav-item>
            <b-nav-item>Giáo hội hoàn vũ</b-nav-item>
            <b-nav-item>Giáo hội việt nam</b-nav-item>
            <b-nav-item>Lời chúa</b-nav-item>
            <b-nav-item>Tài liệu</b-nav-item>
            <b-nav-item>Đáp ca</b-nav-item>
            <b-nav-item>Hôn nhân</b-nav-item>
            <b-nav-item>Tiếng việt</b-nav-item>
            <b-nav-item>Văn kiện</b-nav-item>
            <b-nav-item><b-icon icon="person-fill"></b-icon></b-nav-item>
            <b-nav-item><b-icon icon="search"></b-icon></b-nav-item>
        </b-nav>
    </nav>
</template>

<script>
    export default {
        name: 'Navigation'
    }
</script>

<style lang="scss" scoped>
    #nav {
        border: 1px solid #ED1C24;
        .nav-item {
            a {
                color: #000000;
                font-size: 12px;
                font-weight: 600;
                text-transform: uppercase;
                &.active,
                &:hover {
                    background-color: #ED1C24;
                    color: #ffffff;
                }
            }
            &:first-child,
            &:last-child {
                a {
                    background-color: #ED1C24;
                    color: #ffffff;
                }
            }
            &:nth-child(11) {
                border-left: 1px solid #ED1C24;
            }
        }
    }
</style>