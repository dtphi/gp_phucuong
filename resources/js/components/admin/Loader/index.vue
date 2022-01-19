<template>
  <div class="fa-3x">
    <i class="fas fa-spinner fa-pulse" v-bind:style="{fontSize: size + 'px'}"></i>
  </div>
</template>
<script>

export default {
  name: 'AdminLoader',
  props: {
    size: { type: Number, default: 21, },
  },
}
</script>
