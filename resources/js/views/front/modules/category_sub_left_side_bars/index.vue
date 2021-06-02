<template>
    <div class="fz-0">
        <h4 class="title"><span>Danh mục</span></h4>
        <nav id="nav">
            <ul class="menu-pc nav-menu">
                <nav-tree
                    v-for="(itemMenu,idx) in menuLists"
                    :item="itemMenu"
                    :key="idx"></nav-tree>
            </ul>
        </nav>
    </div>
</template>

<script>
    import {
        mapState
    } from 'vuex';

    import NavMainItem from './components/Item';
    import NavTree from './components/TreeItem';

    export default {
        name: 'ModuleCategorySubLeftSideBar',
        components: {
            NavMainItem,
            NavTree
        },
        props: {
            menuItems: null,
            layoutId: 0
        },
        data() {
            return {
                isHiddenMenu: false
            }
        },
        computed: {
            ...mapState({
                menuLists: state => state.info.module_category_sub_left_side_bar,
            }),
        },
        setting: {
            menuHome: {
                children: [],
                name: 'Home',
                link: 'home'
            }
        }
    }
</script>

<style lang="scss">
    @import './style.scss';
</style>
