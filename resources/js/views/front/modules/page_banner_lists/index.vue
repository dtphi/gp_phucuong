<template>
    <div id="module-page-banner-list">
        <div class="list-home mt-4 mb-3">
            <figure-item-page 
                v-for="(item, idx) in pageLists" 
                :key="idx" 
                :page-item="item"></figure-item-page>
        </div>
    </div>
</template>

<script>
    import {
        mapState,
        mapGetters,
        mapActions
    } from 'vuex';
    import FigureItemPage from './components/TheItemPage';
    import {
        MODULE_HOME
    } from '@app/stores/front/types/module-types';
    import {
        GET_LISTS
    } from '@app/stores/front/types/action-types';

    export default {
        name: 'HomePage',
        components: {
            FigureItemPage,
        },
        data() {
            return {
            }
        },
        computed: {
            /*
            map return Promise().
            ...mapActions(MODULE_HOME, [
                GET_LISTS
            ]),*/
            ...mapState({
                pages: state => state.cfApp.setting.pages
            }),
            ...mapGetters(MODULE_HOME, [
                'pageLists',
                'loading'
            ]),
            _isContentTop() {
                return this.$route.meta.layout_content.content_top;
            },
        },
        methods: {
            ...mapActions(MODULE_HOME, {
                'getList':GET_LISTS
            }),
        },
        mounted() {
            this.getList(this.$route.params);
        }
    }
</script>

<style lang="scss">
    @import './home-style.scss';
</style>
