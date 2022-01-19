<template>
  <div class="tab-content">
    <item-youtube></item-youtube>
  </div>
</template>

<script>
import ItemYoutube from './Infos/ItemYoutube'

export default {
  name: 'TheTabDataYoutube',
  components: {
    ItemYoutube,
  },
  props: {
    moduleData: {
      type: Object,
    },
  },
}
</script>
