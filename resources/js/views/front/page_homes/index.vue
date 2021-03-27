<template>
    <main id="homepage" class="py-2">
        <div class="container">
            <navigation-main :menu-items="navMainLists"></navigation-main>
            <div class="list-home mt-4 mb-3">
                <figure-item-page v-for="(item, idx) in pageLists" :key="idx" :page-item="item"></figure-item-page>
            </div>
        </div>
    </main>
</template>

<script>
    import{
        mapGetters,
        mapActions
    } from 'vuex';
    import NavigationMain from 'com@front/Navigation/Main';
    import FigureItemPage from './components/TheItemPage';
    import {
        MODULE_HOME
    } from '@app/stores/front/types/module-types';
    import {
        GET_LISTS
    } from '@app/stores/front/types/action-types'

    export default {
        name: 'HomePage',
        components: {
            NavigationMain,
            FigureItemPage,
        },
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters(['navMainLists']),
            ...mapGetters(MODULE_HOME, [
                'pageLists'
            ])
        },
        mounted() {
            this.$store.dispatch(MODULE_HOME + '/' + GET_LISTS);
        }
    }
</script>

<style lang="scss">
    @import './home-style.scss'
</style>
