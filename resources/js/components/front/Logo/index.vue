<template>
  <transition>
    <a class="d-inline-block" href="/">
      <img v-if="logoUrl" :src="logoUrl" alt="Logo Phú Cường" />
    </a>
  </transition>
</template>

<script>
import { mapGetters, } from 'vuex'

export default {
  name: 'AppLogo',
  computed: {
    ...mapGetters(['logoUrl']),
  },
}
</script>
