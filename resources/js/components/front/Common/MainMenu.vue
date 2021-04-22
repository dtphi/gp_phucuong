<template>
    <div class="fz-0">
        <nav id="nav">
            <ul class="nav-menu">
              <nav-main-item :title="$options.setting.menuHome.name" activeClass="active"></nav-main-item>
              <nav-tree v-for="(itemMenu,idx) in _menuLists" :item="itemMenu" :key="idx"></nav-tree>
            </ul>
        </nav>
        <div class="icon-nav">
            <p><b-icon class="person" icon="person-fill"></b-icon></p>
            <p><b-icon class="search" icon="search"></b-icon></p>
        </div>
    </div>
</template>

<script>
import {
    mapState
}  from 'vuex';

	import NavMainItem from './MainMenus/Item';
  import NavTree from './MainMenus/TreeItem';

  export default {
      name: 'MainMenu',
      components: {
        NavTree,
        NavMainItem
      },
      props: {
        menuItems: null,
        layoutId : 0
      },
      computed: {
          ...mapState({
              menus: state => state.cfApp.setting.menus,
              menus_1: state => state.cfApp.setting.menus_1
          }),
        _menuLists() {
          const layoutId = parseInt(this.layoutId);

          switch(layoutId) {
            case 0: {
              return this.menus;

              break;
            }
            case 1: {
              return this.menus_1;

              break;
            }
            default: {
              return this.menus;
              break;
            }
          }
        }
      },
      setting: {
          menuHome: {
              children: [],
              name: 'Home'
          }
      }
  }
</script>

<style lang="scss">
    @import './MainMenus/main-menu-style.scss';
</style>