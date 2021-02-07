<template>
  <li>
  	<TheItem :group="item" :is-folder="isFolder"/>
  	
    <ul class="nested" v-if="isFolder">
      <TheTreeItem
        class="treeview-animated-items"
        v-for="(child, index) in item.children"
        :key="index"
        :item="child"
      />
    </ul>
  </li>
</template>

<script>
	import TheItem from './TheItem';

export default {
  name: 'TheTreeItem',
  components: {
    'TheTreeItem': this,
    'TheItem' : TheItem
  },
  props: {
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
