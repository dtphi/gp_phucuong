<template>
  <div class="home">
    <img alt="Vue logo" :src="cfApp.logoPath">
    <div>Lịch Công Giáo</div>
  </div>
</template>

<script>
// @ is an alias to /src
import  {mapGetters}  from  'vuex'

export default {
  name: 'Home',
  computed: {
    ...mapGetters(['cfApp'])
  }
}
</script>
