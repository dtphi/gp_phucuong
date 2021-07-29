<template>
    <header id="header" :style="{backgroundColor:logoBgColor}">
        <div class="header-news" :style="{backgroundColor:titleBgColor}">
            <div class="container">
                <div class="breaking-news d-inline-block" style="text-align: right;">
                    <h4 class="title-breaking-news d-inline-block"></h4>
                    <p class="txt-breaking-news d-inline-block" >{{title}}</p>
                </div>
                <div class="subscribe d-inline-block" :style="{backgroundColor:phoneBgColor}">
                    <button class="btn"><i class="fa fa-phone" aria-hidden="true"></i>{{phone}}</button>
                </div>
            </div>
        </div>
        <banner></banner>
    </header>
</template>

<script>
    import {
        mapState
    } from 'vuex';
	import Banner from './Default/Banner';

    export default {
        name: 'DefaultHeader',
        components: {Banner},
        computed: {
            ...mapState({
                phone: state => state.cfApp.setting.phone,
                phoneBgColor: state => state.cfApp.setting.phoneBgColor,
                title: state => state.cfApp.setting.headerTitle,
                titleBgColor: state => state.cfApp.setting.headerBgColor,
                logoBgColor: state => state.cfApp.setting.logoBgColor
            }),
        }
    };
</script>

<style lang="scss">
    @import './default-style.scss';
</style>