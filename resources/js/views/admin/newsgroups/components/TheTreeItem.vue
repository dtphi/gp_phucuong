<template>
  <li>
  	<Item :name="item.name" :is-folder="isFolder"/>
  	
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
	import Item from './TheItem';

export default {
  name: 'TheTreeItem',
  components: {
    'TheTreeItem': this,
    'Item' : Item
  },
  props: {
    item: Object
  },
  data: function() {
    return {
      isOpen: false
    };
  },
  computed: {
    isFolder: function() {
      return this.item.children && Object.keys(this.item.children).length;
    }
  },
  methods: {
  },
  txtMsg: { }
};
</script>
