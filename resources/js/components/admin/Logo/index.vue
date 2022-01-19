<template>
  <transition>
    <img :src="cfApp.logo" alt="Logo Phú Cường">
  </transition>
</template>

<script>
import { mapState, } from 'vuex'

export default {
  name: 'AdminLogo',
  computed: {
    ...mapState(['cfApp']),
  },
}
</script>
