<template>
    <main id="homepage" class="py-2">
        <div class="container">
            <main-menu :layout-id="_layoutId"></main-menu>
            <div class="list-home mt-4 mb-3">
                <figure-item-page v-for="(item, idx) in pageLists" :key="idx" :page-item="item"></figure-item-page>
            </div>
        </div>
    </main>
</template>

<script>
    import{
        mapState,
        mapGetters,
    } from 'vuex';
    import MainMenu from 'com@front/Common/MainMenu';
    import FigureItemPage from './components/TheItemPage';
    import {
        MODULE_HOME
    } from '@app/stores/front/types/module-types';
    import {
        GET_LISTS
    } from '@app/stores/front/types/action-types';

    const fnIsObject = (obj) => {
    if (typeof obj !== "undefined" 
        && typeof obj === "object" 
        && Object.keys(obj).length) {
        return true;
    }

    return false;
    }

    export default {
        name: 'HomePage',
        components: {
            FigureItemPage,
            MainMenu,
        },
        data() {
            return {
                layoutId: 1
            }
        },
        computed: {
            ...mapState({
                pages: state => state.cfApp.setting.pages
            }),
            ...mapGetters(['navMainLists']),
            ...mapGetters(MODULE_HOME, [
                'pageLists'
            ]),
            _layoutId() {
                if (fnIsObject(this.pages)) {
                    return this.pages.home.id;
                }

                return this.layoutId;
            }
        },
        mounted() {
            this.$store.dispatch(MODULE_HOME + '/' + GET_LISTS);
        }
    }
</script>

<style lang="scss">
    @import './home-style.scss'
</style>
