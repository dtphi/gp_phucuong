<template>
  <transition>
    <img :src="logoUrl" alt="Logo Phú Cường" />
  </transition>
</template>

<script>
import { mapGetters, } from 'vuex'

export default {
  name: 'AppLayzyLogo',
  computed: {
    ...mapGetters(['logoUrl']),
  },
}
</script>
