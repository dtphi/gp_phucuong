<template>
  <div :class="isFixed?'fixed-top':''">
    <div class="fz-0" :class="isFixed?'container':''">
      <nav id="nav">
        <ul class="menu-pc nav-menu">
          <nav-main-item
            :group="$options.setting.menuHome"
            :link="$options.setting.menuHome.link"
            activeClass="active"
          ></nav-main-item>
          <nav-tree
            v-for="(itemMenu, idx) in _menuLists"
            :item="itemMenu"
            :key="idx"
          ></nav-tree>
        </ul>

        <ul class="menu-sp nav-menu">
          <nav-main-mobile-item
            :group="$options.setting.menuHome"
            :link="$options.setting.menuHome.link"
            activeClass="active"
          >
            <div class="hambuger" @click="isHiddenMenu = !isHiddenMenu">
              <div class="bar1"></div>
              <div class="bar2"></div>
              <div class="bar3"></div>
            </div>
          </nav-main-mobile-item>

          <div v-show="isHiddenMenu" class="dropdown">
            <mobile-nav-tree
              v-for="(itemMenu, idx) in _menuLists"
              :item="itemMenu"
              :key="idx"
            ></mobile-nav-tree>
          </div>
        </ul>
      </nav>
      <div class="icon-nav">
        <p>
          <i class="person fas">&#xf406;</i>
        </p>
        <p>
          <i class="search fas">&#xf002;</i>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { throttle, } from 'throttle-debounce'
import { mapState, } from 'vuex'
import NavMainItem from './MainMenus/Item'
import NavMainMobileItem from './MainMenus/MobileItem'
import NavTree from './MainMenus/TreeItem'
import MobileNavTree from './MainMenus/MobileTreeItem'
const THROTTLE_DELAY = 100

export default {
  name: 'MainMenu',
  components: {
    NavTree,
    MobileNavTree,
    NavMainItem,
    NavMainMobileItem,
  },
  props: {
    menuItems: null,
    layoutId: {
      default() {
        return 0
      },
    },
  },
  data() {
    return {
      isHiddenMenu: false,
      throttleScroll: null,
      boundary: 100,
      isFixed: false,
    }
  },
  computed: {
    ...mapState({
      menus: (state) => state.cfApp.setting.menus,
      menus_1: (state) => state.cfApp.setting.menus_1,
    }),
    _menuLists() {
      const layoutId = parseInt(this.layoutId)

      switch (layoutId) {
      case 0: {
        return this.menus

      }
      case 1: {
        return this.menus

      }
      default: {
        return this.menus
      }
      }
    },
  },
  created() {
    this.throttleScroll = throttle(THROTTLE_DELAY, this._handleScroll)
    window.addEventListener('scroll', this.throttleScroll)
  },
  methods: {
    _handleScroll() {
      this.isFixed = window.pageYOffset > this.boundary
    },
  },
  setting: {
    menuHome: {
      children: [],
      name: 'Home',
      link: 'trang-chu',
    },
  },
}
</script>

<style lang="scss">
@import './MainMenus/main-menu-style.scss';
</style>
