<template>
    <div>
        <p class="mb-4">
            <logo></logo>
        </p>
        <h4 class="title mb-3">{{logoTitle}}</h4>
        <p class="mb-0">Ban Truyền Thông Giáo Phận</p>
        <p>104 Lạc Long Quân, Phường Phú Cường, Tp. Thủ Dầu Một, Tỉnh Bình Dương</p>
        <p class="mb-0">+84 274 730 7788</p>
        <p class="mb-0">{{email}}</p>
    </div>
</template>

<script>
    import {
        mapState
    } from 'vuex';
    import Logo from 'com@front/Logo';

    export default {
        name: 'SummaryContact',
        components: {
        	Logo
        },
        computed: {
            ...mapState({
                logoTitle: state => state.cfApp.setting.logoTitle,
                email: state => state.cfApp.setting.email,
            }),
        }
    };
</script>
