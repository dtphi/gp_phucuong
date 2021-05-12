<template>
    <main id="video" class="py-2">
        <div class="container">
            <main-menu></main-menu>
            <b-row class="mt-3">
                <b-col class="col-mobile" cols="3">
                    <side-bar class="aside"></side-bar>
                </b-col>
                <b-col class="col-mobile" cols="9">
                    <div class="list-videos">
                        <the-video-item class="figure"
                                        v-for="(item,idx) in infoList"
                                        :info="item"
                                        :key="idx"></the-video-item>
                    </div>
                </b-col>
            </b-row>
        </div>
    </main>
</template>

<script>
    import {
        mapGetters,
        mapActions,
        mapState
    } from 'vuex';
    import MainMenu from 'com@front/Common/MainMenu';
    import SideBar from 'com@front/SideBar';
    import TheVideoItem from './components/TheVideoItem';

    import {
        MODULE_INFO
    } from '@app/stores/front/types/module-types';
    import {
        GET_INFORMATION_LIST_TO_CATEGORY
    } from '@app/stores/front/types/action-types';

    export default {
        name: 'InfoListtoCategory',
        components: {
            MainMenu,
            SideBar,
            TheVideoItem
        },
        data() {
            return {}
        },
        computed: {
            ...mapGetters(['navMainLists']),
            ...mapState(MODULE_INFO, {
                infoList: state => state.pageLists
            }),
        },
        mounted() {
            const params = {
                infoType: 2,
                ...this.$route.params
            };

            this.[GET_INFORMATION_LIST_TO_CATEGORY](params);
        },
        methods: {
            ...mapActions(MODULE_INFO, [
                GET_INFORMATION_LIST_TO_CATEGORY,
            ]),
        }
    }
</script>

<style lang="scss">
    @import './video-styles.scss';
</style>
