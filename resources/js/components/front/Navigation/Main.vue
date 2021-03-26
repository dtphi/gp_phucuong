<template>
    <div class="fz-0">
        <nav id="nav">
            <ul class="nav-menu">
              <nav-main-item :title="menuItems.newsgroupname" activeClass="active"></nav-main-item>
              <nav-tree v-for="(itemMenu,idx) in _menuLists.children" :item="itemMenu" :key="idx"></nav-tree>
            </ul>
        </nav>
        <div class="icon-nav">
            <p><b-icon class="person" icon="person-fill"></b-icon></p>
            <p><b-icon class="search" icon="search"></b-icon></p>
        </div>
    </div>
</template>

<script>
	import NavMainItem from './Main/Item';
  import NavTree from './Main/TreeItem';

  export default {
      name: 'NavigationMain',
      components: {
        NavTree,
        NavMainItem
      },
      props: {
        menuItems: null
      },
      computed: {
        _menuLists() {
          return this.menuItems
        }
      }
  }
</script>

<style lang="scss">
    @import './main-style.scss';
</style>