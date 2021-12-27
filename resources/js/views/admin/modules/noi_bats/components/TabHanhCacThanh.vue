<template>
  <div class="tab-content">
    <item-hanh-cac-thanh></item-hanh-cac-thanh>
  </div>
</template>

<script>
import ItemHanhCacThanh from './Infos/ItemHanhCacThanh'

export default {
  name: 'TheTabDataHanhCacThanh',
  components: {
    ItemHanhCacThanh,
  },
  props: {
    moduleData: {
      type: Object,
    },
  },
}
</script>
