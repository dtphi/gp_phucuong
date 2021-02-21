<template>
  <li>
  	<NewsGroupItem :is-item-root="isRoot" :group="item" :is-folder="isFolder"/>
  	
    <ul class="nested" v-if="isFolder">
      <NewsGroupTreeItem
        class="treeview-animated-items"
        v-for="(child, index) in item.children"
        :key="index"
        :item="child"
      />
    </ul>
  </li>
</template>

<script>
	import NewsGroupItem from './Item';

export default {
  name: 'NewsGroupTreeItem',
  components: {
    'NewsGroupTreeItem': this,
    'NewsGroupItem' : NewsGroupItem
  },
  props: {
    isRoot: 0,
    item: [Object, Array]
  },
  data: function() {
    return {
    };
  },
  computed: {
    isFolder () {
      return this.item.children && Object.keys(this.item.children).length;
    }
  }
};
</script>
