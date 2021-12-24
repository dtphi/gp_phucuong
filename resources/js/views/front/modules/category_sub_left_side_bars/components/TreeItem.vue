<template>
  <li>
    <nav-item :group="item"></nav-item>
    <ul v-if="isFolder">
      <nav-tree
        v-for="(child, index) in item.children"
        :key="index"
        :item="child"
      ></nav-tree>
    </ul>
  </li>
</template>

<script>
import NavItem from './Item'

export default {
  name: 'NavTree',
  components: {
    NavTree: this,
    NavItem: NavItem,
  },
  props: {
    isRoot: 0,
    item: [Object, Array],
  },
  data: function () {
    return {}
  },
  computed: {
    isFolder() {
      return this.item.children && Object.keys(this.item.children).length
    },
  },
}
</script>
