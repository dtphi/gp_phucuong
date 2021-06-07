<template>
    <div class="category-sub-left" v-if="_isExistMenu">
        <h4 class="title"><span>{{menuLists.name}}</span></h4>
        <nav id="nav-category">
            <ul class="nav-menu">
                <nav-tree
                    v-for="(itemMenu,idx) in menuLists.children"
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
            _isExistMenu() {
                return Object.keys(this.menuLists).length > 0;
            }
        },
        setting: {
            menuHome: {
                children: [],
                name: 'Home',
                link: 'trang-chu'
            }
        }
    }
</script>

<style lang="scss">
    @import './style.scss';
</style>
